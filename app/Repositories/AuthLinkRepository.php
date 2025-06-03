<?php

namespace App\Repositories;

use App\Interfaces\AuthLinkRepositoryInterface;
use App\Models\AuthLink;

class AuthLinkRepository implements AuthLinkRepositoryInterface
{
    public function getByUserId(int $userId)
    {
        return AuthLink::query()
            ->where('user_id',$userId)
            ->where('expires_at', '>', now())
            ->where('is_deactivated', false)
            ->first();
    }

    public function getByToken(string $token)
    {
        return AuthLink::query()
            ->where('token', $token)
            ->where('expires_at', '>', now())
            ->where('is_deactivated', false)
            ->first();
    }

    public function create(array $details)
    {
        return AuthLink::create($details);
    }

    public function removeActiveToken(int $userId)
    {
        return AuthLink::query()
            ->where('user_id', $userId)
            ->where('is_deactivated', false)
            ->update(['is_deactivated' => true]);
    }
}
