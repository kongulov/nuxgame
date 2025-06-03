<?php

namespace App\Repositories;

use App\Interfaces\GameRepositoryInterface;
use App\Models\Game;

class GameRepository implements GameRepositoryInterface
{
    public function create(array $details)
    {
        return Game::create($details);
    }

    public function lastByToken(string $token)
    {
        return Game::query()
            ->where('token', $token)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    public function lastThreeByToken(string $token)
    {
        return Game::query()
            ->where('token', $token)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
    }
}
