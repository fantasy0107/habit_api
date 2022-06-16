<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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
            Log::emergency($e->getMessage());
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

    /**
     * 用 email 和 password 登入
     *
     * @param [type] $request
     * @return void
     */
    public function loginByEmailAndPassword($request)
    {
        $user = User::where('email', $request->email)->where('type', 'email')->first();
        if (!$user) {
            abort(400, '找不到使用者');
        }

        if (Hash::needsRehash($user->password)) {
            $hashed = Hash::make($user->password);

            if (Hash::check($request->password, $hashed)) {
                $user->password = $hashed;
                $user->save();
            } else {
                abort(400, '密碼錯誤(1)!');
            }
        }

        return $user;
    }

}
