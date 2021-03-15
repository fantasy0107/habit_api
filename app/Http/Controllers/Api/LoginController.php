<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserToken;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{

    public function logIn(Request $request)
    {

        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                return $this->ok([
                    'user' => $user->load('user_token')
                ]);
            }
        }

        abort(400, '找不到使用者');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]);

        $email = $request->emaill;


        $registeredUser = User::where('email', $email)->first();
        if ($registeredUser) {
            abort(400, '已經註冊的使用者');
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password =  Hash::make($request->password);
        $user->save();

        return $this->created([
            'user' => $user
        ]);
    }

    public function loginByFacebook(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        try {
            $facebookUser = Socialite::driver('facebook')->userFromToken($request->token);
        } catch (\Exception $e) {
            abort(400, '發生錯誤');
        }


        $user = User::where('type', 1)->where('email', $facebookUser->email)->first();
        if (!$user) {
            $user = new User;
            $user->name = $facebookUser->name;
            $user->email = $facebookUser->email;
            $user->type = 1;
            $user->password =  '';
            $user->save();

            $userToken  = new UserToken;
            $userToken->user_id = $user->id;
            $userToken->value = Crypt::encryptString($user->id);
            $userToken->save();
        }

        return $this->ok([
            'user' => $user->load('user_token')
        ]);
    }

    public function loginByGoogle(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        try {
            $facebookUser = Socialite::driver('google')->userFromToken($request->token);
        } catch (\Exception $e) {
            abort(400, '發生錯誤');
        }
        $user = User::where('type', 1)->where('email', $facebookUser->email)->first();

        if (!$user) {
            $user = new User;
            $user->name = $facebookUser->name;
            $user->email = $facebookUser->email;
            $user->type = 2;
            $user->password =  '';
            $user->save();

            $userToken  = new UserToken;
            $userToken->user_id = $user->id;
            $userToken->value = Crypt::encryptString($user->id);
            $userToken->save();
        }

        return $this->ok(['user' => $facebookUser]);

        // $user = User::where('type', 1)->where('email', $facebookUser->email)->first();
        // if (!$user) {
        //     $user = new User;
        //     $user->name = $facebookUser->name;
        //     $user->email = $facebookUser->email;
        //     $user->type = 1;
        //     $user->password =  '';
        //     $user->save();

        //     $userToken  = new UserToken;
        //     $userToken->user_id = $user->id;
        //     $userToken->value = Crypt::encryptString($user->id);
        //     $userToken->save();
        // }

        // return $this->ok([
        //     'user' => $user->load('user_token')
        // ]);
    }
}
