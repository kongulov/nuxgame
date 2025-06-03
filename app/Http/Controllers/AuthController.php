<?php

namespace App\Http\Controllers;

use App\Interfaces\AuthLinkRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Repositories\AuthLinkRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private UserRepositoryInterface $userRepository;
    private AuthLinkRepositoryInterface $authLinkRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        AuthLinkRepositoryInterface $authLinkRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->authLinkRepository = $authLinkRepository;
    }

    public function registerForm(Request $request)
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Валидацию можно перенести в Form Request, но для простоты оставил здесь
        $data = $request->validate([
            'username' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
        ]);

        $user = $this->userRepository->first($data['username'], $data['phone_number']);
        if (!$user) {
            $user = $this->userRepository->create([
                'username' => $data['username'],
                'phone_number' => $data['phone_number'],
            ]);
        }

        $link = $this->authLinkRepository->getByUserId($user->id);
        if (!$link) {
            $link = $this->authLinkRepository->create([
                'user_id' => $user->id,
                'token' => Str::uuid(),
                'expires_at' => now()->addDays(7),
            ]);
        }


        auth()->login($user);

        return redirect()->route('home', ['token' => $link->token])->with('success', 'Registration successful!');
    }
}
