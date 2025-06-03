<?php

namespace App\Providers;

use App\Interfaces\AuthLinkRepositoryInterface;
use App\Interfaces\GameRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\AuthLinkRepository;
use App\Repositories\GameRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(AuthLinkRepositoryInterface::class, AuthLinkRepository::class);
        $this->app->bind(GameRepositoryInterface::class, GameRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
