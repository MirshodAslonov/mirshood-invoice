<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Services\Auth\Contracts\AuthServiceInterface;
use App\Services\Auth\DTO\RegisterData;
use Illuminate\Support\Facades\Auth;

/**
 * Class AuthService
 * @package App\Services
 */
class AuthService implements AuthServiceInterface
{
    public function register(RegisterData $data) {
        return User::create($data->toArray());
    }

    public function login(array $credentials) {
        // To'g'ri attempt: ['email' => ..., 'password' => ...]
        if (!Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ])) {
            return ['success'=>false,'message'=>'Login or password invalid'];
        }

        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;

        return [
            'success' => true,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ];
    }
}
