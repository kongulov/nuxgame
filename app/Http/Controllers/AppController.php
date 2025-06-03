<?php

namespace App\Http\Controllers;

use App\Interfaces\AuthLinkRepositoryInterface;
use App\Interfaces\GameRepositoryInterface;
use App\Services\GameService;
use Illuminate\Support\Str;

class AppController extends Controller
{
    private AuthLinkRepositoryInterface $authLinkRepository;
    private GameRepositoryInterface $gameRepository;
    private GameService $gameService;

    public function __construct(
        AuthLinkRepositoryInterface $authLinkRepository,
        GameRepositoryInterface $gameRepository,
        GameService $gameService
    )
    {
        $this->authLinkRepository = $authLinkRepository;
        $this->gameRepository = $gameRepository;
        $this->gameService = $gameService;
    }
    public function home(string $token)
    {
        $link = $this->authLinkRepository->getByToken($token);
        if (!$link) {
            auth()->logout();
            return redirect('/')->with('error', 'Invalid or expired link.');
        }

        $lastGame = $this->gameRepository->lastByToken($link->token);

        return view('app.home', [
            'last_game' => $lastGame,
            'token' => $link->token,
        ]);
    }

    public function createNewToken()
    {
        $user = auth()->user();

        $this->authLinkRepository->removeActiveToken($user->id);

        $newToken = $this->authLinkRepository->create([
            'user_id' => $user->id,
            'token' => Str::uuid(),
            'expires_at' => now()->addDays(7),
        ]);

        return redirect()->route('home', ['token' => $newToken->token])
            ->with('success', 'New token created successfully.');
    }

    public function deactivateToken()
    {
        $user = auth()->user();

        $this->authLinkRepository->removeActiveToken($user->id);

        auth()->logout();

        return redirect('/')
            ->with('success', 'Token deactivated successfully.');
    }

    public function imfeelinglucky()
    {
        $user = auth()->user();

        $token = $this->authLinkRepository->getByUserId($user->id);
        if (!$token) return redirect('/');

        $result = $this->gameService->play();

        $this->gameRepository->create([
            'user_id' => $user->id,
            'token' => $token->token,
            'rand' => $result['rand'],
            'amount' => $result['amount'],
            'is_winner' => $result['is_winner'],
        ]);

        return redirect()->route('home', ['token' => $token->token]);
    }

    public function history($token)
    {
        $user = auth()->user();

        $userToken = $this->authLinkRepository->getByUserId($user->id);
        if (!$userToken) return redirect('/');
        if ($userToken->token !== $token) return redirect('/');

        $games = $this->gameRepository->lastThreeByToken($userToken->token);

        return view('app.history', [
            'games' => $games,
            'token' => $userToken->token,
        ]);
    }
}
