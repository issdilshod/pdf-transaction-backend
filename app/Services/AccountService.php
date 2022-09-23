<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

/**
 * Account service class
 * 
 * @version Dev: @1.0.0@
 */
class AccountService {

    /**
     * Return bool if login
     *
     * @param   Array 
     * @param   Request
     * @return  bool
     */
    public function login($login)
    {
        $user = User::where('status', Config::get('custom.status.active'))
                        ->where('username', $login['username'])
                        ->where('password', $login['password'])
                        ->first();
        if ($user==null){
            return false;
        }
        return true;
    }
}