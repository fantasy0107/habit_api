<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class UserService
{
    public function signUp($inputs = [])
    {
        try {
            $user = new User;
            $user->name = $inputs['name'];
            $user->email = $inputs['email'];
            $user->type = $inputs['type'];
            $user->password = in_array($inputs['type'], ['facebook', 'google']) ? '' : Hash::make($inputs['password']);
            $user->api_token =  Str::random(80);
            $user->save();
        } catch (\Exception $e) {
            abort(400, '建立帳號失敗');
        }


        return $user;
    }

    public function loginSocialiteAccount($type, $token)
    {
        try {
            $socialiteAccount = Socialite::driver($type)->userFromToken($token);
        } catch (\Exception $e) {
            abort(400, '第三方登入發生錯誤');
        }

        return $socialiteAccount;
    }
}
