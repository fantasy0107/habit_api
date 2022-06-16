<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Resources\HabitResource;
use App\Http\Resources\PostLoginResource;
use App\Http\Resources\TagResource;
use App\Models\Habit;
use App\Models\User;
use App\Services\UserService;

/**
 * 註冊, Email登入, 第三方登入
 */
class LoginController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * 用 email 和 password 註冊帳號
     *
     * @param Request $request
     * @return array 
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed']
        ]);

        $registeredUser = User::where('email', $request->email)->where('type', 'email')->first();
        if ($registeredUser) {
            abort(400, '已經註冊的使用者');
        }

        return $this->created([
            'user' => $this->userService->signUp([
                'name' => $request->name,
                'email' => $request->email,
                'type' => 'email',
                'password' => Hash::make($request->password),
            ])
        ]);
    }

    /**
     * 用 email 和 password 登入
     *
     * @param Request $request
     * @return void
     */
    public function logIn(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        $user = $this->userService->loginByEmailAndPassword($request);

        if (Hash::check($request->password, $user->password) == false) {
            abort(400, '密碼錯誤!');
        }

        return new PostLoginResource([
            'user' => $user
        ]);
    }


    /**
     * 用 facebook 登入
     *
     * @param Request $request
     * @return void
     */
    public function loginByFacebook(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        $facebookUser = $this->userService->loginSocialiteAccount('facebook', $request->token);
        $user = User::where('type', 'facebook')->where('email', $facebookUser->email)->first();

        return $user ? $this->returnSignUpAccountResponse($user) : [
            'user' => $this->userService->signUp([
                'name' => $facebookUser->name,
                'email' => $facebookUser->email,
                'type' => 'facebook'
            ])
        ];
    }

    /**
     * 用 google 登入
     *
     * @param Request $request
     * @return void
     */
    public function loginByGoogle(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        $googleUser = $this->userService->loginSocialiteAccount('google', $request->token);
        $user = User::where('type', 'google')->where('email', $googleUser->email)->first();

        return $user ? $this->returnSignUpAccountResponse($user) : [
            'user' => $this->userService->signUp([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'type' => 'google'
            ])
        ];
    }

    public function loginByToken(Request $request)
    {
        $request->validate([
            'api_token' => 'required'
        ]);

        $user = User::where('api_token', $request->api_token)->first();

        if (!$user) {
            abort(400, '找不到使用者');
        }

        return $this->returnSignUpAccountResponse($user);
    }

    private function returnSignUpAccountResponse($user)
    {
        $habits =  Habit::with('records')->where('user_id', $user->id)->get();
        $records = $habits->keyBy('id')->map(function ($habit, $key) {
            $rercords =  $habit->records;

            if (count($rercords)) {
                return $rercords->pluck('finish_date')->filter(function ($value) {
                    return $value != null;
                })->values();
            }

            return  [];
        })->filter();



        $tags = $user->tags;

        return $this->ok([
            'user' => $user,
            'habit_ids' => $habits->pluck('id'),
            'tag_ids' => $tags->pluck('id'),
            'habit_records' => $records,
            'db' => [
                'habits' => HabitResource::collection($habits->keyBy->id),
                'tags' => TagResource::collection($tags->keyBy->id)
            ],
        ]);
    }
}
