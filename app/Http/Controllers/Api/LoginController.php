<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;


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

        $user = Socialite::driver('facebook')->userFromToken($request->token);

        return $user;
    }
}
