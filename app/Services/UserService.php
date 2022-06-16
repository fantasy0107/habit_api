<?php

namespace App\Services;

use App\Constant\UserConstant;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function signUp($inputs = [])
    {
        $type = $inputs['type'] ?? UserConstant::USER_TYPE_EMAIL;
        
        try {
            $user = new User;
            $user->name = $inputs['name'] ?? '預設';
            $user->email = $inputs['email'];
            $user->type = $type;
            $user->password = in_array($type, ['facebook', 'google']) ? '' : Hash::make($inputs['password']);
            $user->api_token =  Str::random(80);
            $user->save();
        } catch (\Exception $e) {
            Log::emergency($e->getMessage());
            abort(400, $e->getMessage());
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

    public function getByFilter($filter)
    {
        return $this->userRepository->getByFilter($filter);
    }

}
