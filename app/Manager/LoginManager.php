<?php

namespace App\Manager;

use App\Http\Resources\UserDetailsResponseResource;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;

class LoginManager
{

    public const OTP_MAX_ALLOWED_ATTEMPT = 3;
    public const OTP_EXPIRE_TIME = 3; // in min
    public const OTP_BLOCK_TIME = 5; // in min

    /**
     * @throws Exception
     */
    public static function processForOTP(User|Model $user): bool
    {
        $otp      = self::generate_otp();
        $otp_text = 'Your login OTP ' . $otp;
        FileManager::createFile($otp_text);
        $user_data = [
            'otp_expires_at' => Carbon::now()->addMinutes(self::OTP_EXPIRE_TIME),
            'otp'            => $otp,
            'otp_attempt'    => $user->otp_attempt + 1,
            'otp_block_time' => null,
        ];

        return $user->update($user_data);
    }

    public static function login(User|Model $user)
    {
        self::resetOTPData($user);
        return $user->createToken($user->email)->plainTextToken;
    }

    public static function resetOTPData(User|Model $user): void
    {
        $user->update([
            'otp'            => null,
            'otp_block_time' => null,
            'otp_expires_at' => null,
            'otp_attempt'    => null,
        ]);
    }

    /**
     * @return int
     * @throws Exception
     */
    private static function generate_otp(): int
    {
        return random_int(100000, 999999);
    }

}
