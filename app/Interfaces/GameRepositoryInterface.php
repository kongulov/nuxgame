<?php

namespace App\Interfaces;

interface GameRepositoryInterface
{
    public function lastByToken(string $token);
    public function create(array $details);
    public function lastThreeByToken(string $token);
}
