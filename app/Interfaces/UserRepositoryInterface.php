<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function first(string $username, int $phoneNumber);
    public function create(array $details);
}
