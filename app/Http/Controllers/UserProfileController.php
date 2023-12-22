<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\User;
use App\Manager\Utility;
use Illuminate\View\View;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Manager\CommonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Manager\ImageUploadManager;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreUserProfileRequest;
use App\Http\Requests\UpdateUserProfileRequest;

class UserProfileController extends Controller
{
    /**
     * @return View
     */
    public function index():View
    {
        $page_content = [
            'page_title'      => __('Profile'),
            'module_name'     => __('Profile'),
            'sub_module_name' => __('update'),
        ];

        $userProfile = UserProfile::where('user_id',Auth::id())->first();
        $user        =  Auth::user();
        return view('user_profile.index',compact('userProfile','user','page_content'));
    }

    /**
     * @return View
     */
    public function create()
    {


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserProfileRequest $request)
    {

        try {
            DB::beginTransaction();
            $user = (new User())->updateUserData($request);
            (new UserProfile())->storeUserProfile($request, $user);
            DB::commit();
            $message = 'User Profile added successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
             DB::rollBack();
             Log::info('USER__PROFILE__SAVE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
             $message = 'Failed! ' . $throwable->getMessage();
             $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(UserProfile $userProfile)
    {
        //
    }

    /**
     * @param UserProfile $userProfile
     * @return View
     */
    public function edit(UserProfile $userProfile):View
    {



    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserProfileRequest $request, UserProfile $userProfile)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserProfile $userProfile)
    {
        //
    }

    final public function updateOrCreateProfile(Request $request, $userId = null): JsonResponse
    {
        $commonResponse = new CommonResponse();
        try {
            // Validate the request data
            $this->validate($request, [
                'email' => 'email|max:255',
                'phone' => [
                            'regex:/^01[3-9]\d{8}$/'
                ],
                'emergency_contact_no'=>[
                            'regex:/^01[3-9]\d{8}$/'
                ],
                'national_id_card_no'=>[
                            'regex:/^[0-9]{13}$/'
                ],
                'date_of_birth' => 'date_format:d-m-Y',
                // 'emergency_contact_no'=>[
                //             'regex:/^01[3-9]\d{8}$/',
                //             'unique:users'
                // ],
            ]);
            DB::beginTransaction();
            $userProfile = UserProfile::where('user_id', $userId)->first();
            $user = User::findOrFail($userId);
            $user->update([
                'name'  => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
            ]);

            $userProfileData = [
                'date_of_birth'        => $request->input('date_of_birth'),
                'national_id_card_no'  => $request->input('national_id_card_no'),
                'emergency_contact_no' => $request->input('emergency_contact_no'),
            ];

            //profile photo
            $profile_photo   = $userProfile->profile_photo;
            if ($request->hasFile('profile_photo')) {
                if ($profile_photo) {
                ImageUploadManager::deletePhoto(UserProfile::PHOTO_UPLOAD_PATH, $userProfile->profile_photo);
                }
                $profilePhoto  = (new ImageUploadManager)->file($request->file('profile_photo'))
                    ->name(Utility::prepare_name($request->input('name')))
                    ->path(UserProfile::PHOTO_UPLOAD_PATH)
                    ->height(UserProfile::PHOTO_HEIGHT)
                    ->width(UserProfile::PHOTO_WIDTH)
                    ->upload();
                $userProfileData['profile_photo'] = $profilePhoto;
            }

            //national ID photo
            $national_id_photo   = $userProfile->national_id_photo;
            if ($request->hasFile('national_id_photo')) {  
                if ($national_id_photo) {
                ImageUploadManager::deletePhoto(UserProfile::NATIONAL_ID_PHOTO_UPLOAD_PATH, $userProfile->national_id_photo);
                } 
                $nationalIdPhoto  = (new ImageUploadManager)->file($request->file('national_id_photo'))
                    ->name(Utility::prepare_name($request->input('name')))
                    ->path(UserProfile::NATIONAL_ID_PHOTO_UPLOAD_PATH)
                    ->height(UserProfile::NATIONAL_ID_PHOTO_HEIGHT)
                    ->width(UserProfile::NATIONAL_ID_PHOTO_WIDTH)
                    ->upload();
                $userProfileData['national_id_photo'] = $nationalIdPhoto;
            }

            if ($userProfile) {
                $userProfile->update($userProfileData);
            } else {
                $user->profile()->create($userProfileData);
            }
            DB::commit();
            $commonResponse->status_message = __('User Profile updated or created successfully');
        } catch (\Throwable $throwable) {
            Log::info('USER_PROFILE_UPDATE_CREATE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $commonResponse->status_message = 'Failed! ' . $throwable->getMessage();
            $commonResponse->status_code = CommonResponse::STATUS_CODE_FAILED;
            $commonResponse->status = false;
        }
        return $commonResponse->commonApiResponse(); 
    }





}
