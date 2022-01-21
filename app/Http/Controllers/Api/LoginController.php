<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class LoginController extends Controller
{

    public function logIn(Request $request)
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

                return $this->ok([
                    'user' => $user
                ]);
            } else {
                abort(400, '密碼錯誤(1)!');
            }
        }

        if (Hash::check($request->password, $user->password) == false) {
            abort(400, '密碼錯誤!');
        }

        return $this->ok([
            'user' => $user
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ]);

        $registeredUser = User::where('email', $request->email)->first();
        if ($registeredUser) {
            abort(400, '已經註冊的使用者');
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->api_token =  Str::random(80);
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
            $user->api_token =  Str::random(80);
            $user->save();
        }

        return $this->ok([
            'user' => $user
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
        $user = User::where('type', 2)->where('email', $facebookUser->email)->first();

        if (!$user) {
            $user = new User;
            $user->name = $facebookUser->name;
            $user->email = $facebookUser->email;
            $user->type = 2;
            $user->password =  '';
            $user->api_token =  Str::random(80);
            $user->save();
        }

        return $this->ok([
            'user' => $user
        ]);
    }
}
