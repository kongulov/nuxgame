<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function first(string $username, int $phoneNumber)
    {
        return User::query()
            ->where('username',$username)
            ->where('phone_number', $phoneNumber)
            ->first();
    }

    public function create(array $details)
    {
        return User::create($details);
    }
}
