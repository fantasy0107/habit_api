<?php

namespace App\Observers;

use App\Constant\ProjectConstant;
use App\Mail\Welcome;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Repositories\ProjectRepository;

class UserObserver
{

    /**
     * Handle the User "created" event.
     *
     * @param \App\Models\User $user
     *
     * @return void
     */
    public function created(User $user)
    {
        // Mail::to($user->email)->send(new Welcome($user));

        app(ProjectRepository::class)->save([
            'project' => [
                'user_id' => $user->id,
                'title'   => '',
                'type'    => ProjectConstant::PROJECT_TYPE_BOX
            ]
        ]);
        app(ProjectRepository::class)->save([
            'project' => [
                'user_id' => $user->id,
                'title'   => '',
                'type'    => ProjectConstant::PROJECT_TYPE_TODAY
            ]
        ]);
    }
}
