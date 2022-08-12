<?php

namespace App\Repositories;
use App\Models\User;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }


    public function getByFilter($filter)
    {
        $query = $this->user->newQuery();

        if (isset($filter['email'])) {
            $query->where('email', $filter['email']);
        }
        
        return $query->get();
    }
}