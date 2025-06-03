<?php

namespace App\Interfaces;

interface AuthLinkRepositoryInterface
{
    public function getByUserId(int $userId);
    public function getByToken(string $token);
    public function create(array $details);

    public function removeActiveToken(int $userId);
}
