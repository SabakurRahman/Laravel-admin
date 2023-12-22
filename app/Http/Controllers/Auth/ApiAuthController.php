<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserDetailsResponseResource;
use App\Manager\CommonResponse;
use App\Manager\FileManager;
use App\Manager\LoginManager;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Throwable;

class ApiAuthController extends Controller
{

    private CommonResponse $commonResponse;

    public function __construct()
    {
        $this->commonResponse = new CommonResponse();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    final public function login(Request $request)
    {
        $this->validate($request, [
            'email_or_phone' => 'required',
            'password'       => 'required',
        ]);
        try {
            $email_or_phone = $request->input('email_or_phone');
            if ($request->has('otp_login_request')) { // if request for otp
                if (is_numeric($email_or_phone) && strlen($email_or_phone) == 11) {
                    $user = (new User())->getUserByColumn('phone', $email_or_phone);
                    if ($user) {
                        LoginManager::processForOTP($user);
                        $this->commonResponse->status_message = 'OTP sent successfully';
                        return $this->commonResponse->commonApiResponse();
                    }

                    throw ValidationException::withMessages(['email_or_phone' => 'Please register first to login']);
                }

                throw ValidationException::withMessages(['email_or_phone' => 'Please insert a valid phone number']);
            }

            if ($request->has('otp')) {
                $user = (new User())->getUserByColumn('phone', $email_or_phone);
                if ($user && $user->otp == $request->input('otp')) {
                    if (Carbon::parse($user->otp_expires_at)->greaterThan(Carbon::now())) {
                        $this->commonResponse->data           = [
                            'token' => LoginManager::login($user),
                            'user'  => new UserDetailsResponseResource($user),
                        ];
                        $this->commonResponse->status_message = __('Login successful');
                    } else {
                        LoginManager::resetOTPData($user);
                        throw ValidationException::withMessages(['email_or_phone' => 'OTP Expires']);
                    }
                } else {
                    throw ValidationException::withMessages(['email_or_phone' => 'OTP Mitch match']);
                }
            }

            //with password

            if ($request->has('email_or_phone') && $request->has('password')) {
                if (is_numeric($request->input('email_or_phone')) && strlen($request->input('email_or_phone')) == 11) {
                    $column = 'phone';
                } else {
                    $column = 'email';
                }

                $user = (new User())->getUserByColumn($column, $request->input('email_or_phone'));

                if ($user) {
                    if ($user->status == User::STATUS_ACTIVE) {
                        if (Hash::check($request->input('password'), $user->password)) {
                            $this->commonResponse->data           = [
                                'token' => LoginManager::login($user),
                                'user'  => new UserDetailsResponseResource($user),
                            ];
                            $this->commonResponse->status_message = __('Login successful');
                        } else {
                            throw ValidationException::withMessages([
                                'email' => ['The provided credentials are incorrect.'],
                            ]);
                        }
                    } else {
                        throw ValidationException::withMessages([
                            'email' => ['Your account is inactive.'],
                        ]);
                    }
                }else{
                    throw ValidationException::withMessages([
                        'email' => ['Please register before login'],
                    ]);
                }
            }
        } catch (Throwable $throwable) {
            Log::info('API_USER_LOGIN_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $this->commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $this->commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $this->commonResponse->status         = false;
        }
        return $this->commonResponse->commonApiResponse();
    }

    /**
     * @throws ValidationException
     */
    final public function registration(StoreUserRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $registration_data             = $request->except('photo');
            $registration_data['status']   = User::STATUS_ACTIVE;
            $registration_data['password'] = Hash::make($request->input('password'));
            $user                          = (new User())->storeUser($registration_data);
            $token                         = $user->createToken('token')->plainTextToken;
            $role                          = Role::query()->where('name', 'like', '%customer%')->first();
            if ($role) {
                $user->roles()->sync($role->id);
            }

            $this->commonResponse->data           = [
                'token' => $token,
                'user'  => new UserDetailsResponseResource($user),
            ];
            $this->commonResponse->status_message = __('Registration successful');
            DB::commit();
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('API_USER_REGISTRATION_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $this->commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $this->commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $this->commonResponse->status         = false;
        }
        return $this->commonResponse->commonApiResponse();
    }

    /**
     * @return JsonResponse
     */
    final public function logout(): JsonResponse
    {
        try {
            auth()->user()->tokens()->delete();
            $this->commonResponse->status_message = __('Successfully logged out');
        } catch (Throwable $throwable) {
            Log::info('API_USER_LOGOUT_FAILED', ['error' => $throwable]);
            $this->commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $this->commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            $this->commonResponse->status         = false;
        }
        return $this->commonResponse->commonApiResponse();
    }

    public function changePassword(PasswordResetRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::query()->find(Auth::user()->id);
            if (Hash::check($request->old_password, $user->password)) {
                if (Hash::check($request->password, $user->password)) {
                    $this->commonResponse->status_message = 'Old password and new password are same';
                    $this->commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
                    return $this->commonResponse->commonApiResponse();
                }

                $user->password = Hash::make($request->password);
                $user->save();
                DB::commit();
                $this->commonResponse->status_message = 'Password changed successfully';
                $this->commonResponse->status_code    = CommonResponse::STATUS_CODE_SUCCESS;
                return $this->commonResponse->commonApiResponse();
            }

            $this->commonResponse->status_message = 'Old password does not match';
            $this->commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            return $this->commonResponse->commonApiResponse();
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('API_USER_CHANGE_PASSWORD_FAILED', ['error' => $throwable]);
            $this->commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $this->commonResponse->status_code    = CommonResponse::STATUS_CODE_FAILED;
            return $this->commonResponse->commonApiResponse();
        }
    }


}
