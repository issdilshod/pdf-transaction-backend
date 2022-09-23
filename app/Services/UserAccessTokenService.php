<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserAccessToken;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

/**
 * User access token service class
 * 
 * @version Dev: @1.0.0@
 */
class UserAccessTokenService {

    /**
     * Return access token for user
     * 
     * @param   Request
     * @param   Array
     * @return  UserAccessToken
     */
    public function create_access_token(Request $request, $user)
    {
        $user = User::where('status', Config::get('custom.status.active'))
                        ->where('username', $user['username'])
                        ->where('password', $user['password'])
                        ->first();
        $expires_at = Carbon::now(); $expires_at = $expires_at->addDays(1)->toDateTimeString(); // after day expires
        $entity = [
            'user_id' => $user['id'],
            'token' => Str::random(25),
            'expires_at' => $expires_at,
        ];
        $access_token = UserAccessToken::create($entity);
        return $access_token;
    }

    /**
     * Delete user access token
     * 
     * @param   Array
     * @return  void
     */
    public function delete_user_access_token($user_access_token)
    {
        UserAccessToken::where('token', $user_access_token['token'])->update(['status' => Config::get('custom.status.delete')]);
    }
}