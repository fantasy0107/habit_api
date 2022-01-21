<?php

namespace App\Http\Middleware;

use App\Models\UserToken;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Auth;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $authorization = $request->header('Authorization');

        if (!$authorization) {
            abort(400, '錯誤 1');
        }

        $parts = explode(' ', $authorization);

        if (count($parts) != 2) {
            abort(400, '錯誤 2');
        }

        if ($parts[0] != 'Bearer') {
            abort(400, '錯誤 2');
        }

        $token = $parts[1];
       
        $user = User::where('api_token', $token)->first();
        
        if (!$user->api_token) {
            abort(400, '錯誤 3');
        }

        Auth::login($user);

        return $next($request);
    }
}
