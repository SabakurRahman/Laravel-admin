<?php

namespace App\Manager\Utility;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class System
{

    /**
     * @return bool
     */
    final public static function isAuthUserOnline(): bool
    {
        $is_online = false;
        $threshold = now()->subMinutes(User::ONLINE_THRESHOLD_TIME);
        if (Auth::check() && Auth::user()->last_activity_at >$threshold) {
            $is_online = true;
        }
        return $is_online;
    }

    /**
     * @param User|Model $user
     * @return bool
     */
    final public static function isUserOnline(User|Model $user): bool
    {
        $is_online = false;
        $threshold = now()->subMinutes(User::ONLINE_THRESHOLD_TIME);
        if ($user->last_activity_at > $threshold) {
            $is_online = true;
        }
        return $is_online;
    }
}
