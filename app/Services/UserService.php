<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Config;

/**
 * User service class
 * 
 * @version Dev: @1.0.0@
 */
class UserService {

    /**
     * Returns 20 last added users
     * 
     * @return  Array(User)
     */
    public function get_users()
    {
        $users = User::orderBy('created_at', 'DESC')
                        ->where('status', Config::get('custom.status.active'))
                        ->paginate(20);
        return UserResource::collection($users);
    }

    /**
     * Returns user
     * 
     * @return  User
     */
    public function get_user(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Create user and returns
     * 
     * @param   Array
     * @return  User
     */
    public function create_user($user)
    {
        $exsist = User::where('status', Config::get('custom.status.active'))
                        ->where('username', $user['username'])
                        ->first();
        if ($exsist==null){
            // static role
            $user['role'] = Config::get('custom.role.user');
            $created = User::create($user);
            return new UserResource($created);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    /**
     * Update user and returns
     * 
     * @param   Array
     * @param   User
     * @return  User
     */
    public function update_user($update, User $user)
    {
        $exsist = User::where('status', Config::get('custom.status.active'))
                        ->where('username', $update['username'])
                        ->where('id', '!=', $user->id)
                        ->first();
        if ($exsist==null){
            $user->update($update);
            return new UserResource($user);
        }
        return response()->json([
            'error' => 'Data exsist.'
        ], 409);
    }

    /**
     * Delete user
     * 
     * @param   User
     * @return void
     */
    public function delete_user(User $user)
    {
        $user->update(['status' => Config::get('custom.status.delete')]);
    }
}