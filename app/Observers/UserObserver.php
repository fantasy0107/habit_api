<?php

namespace App\Observers;

use App\Models\UserToken;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $userToken  = new UserToken();
        $userToken->user_id = $user->id;
        $userToken->value = Crypt::encryptString($user->id);
        $userToken->save();

        Mail::to($user->email)->send(new \App\Mail\RegisterMail);
    }
}
