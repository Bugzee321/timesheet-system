<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Token;

class AuthenticationService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Attempt to log in a user.
     *
     * @param array $data
     * @return bool
     */
    public function login(array $data): bool
    {
        return Auth::attempt($data);
    }

    /**
     * Log out the current user.
     *
     * @return void
     */
    public function logout(): void
    {
        $user = Auth::user();

        $user->tokens->each(function (Token $token) {
            $token->revoke();
        });
    }

    /**
     * Create an access token for the user.
     *
     * @param User $user
     * @return string
     */
    public function createToken(User $user): string
    {
        return $user->createToken('LaravelPassportToken')->accessToken;
    }
}
