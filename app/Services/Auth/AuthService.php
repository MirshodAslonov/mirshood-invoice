<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * Class AuthService
 * @package App\Services
 */
class AuthService
{
    public static function register(array $data)
    {
         return User::create($data);
    }

    public static function login(array $data)
    {
        $credentials = [$data['email'], $data['password']];

        if(!Auth::attempt($credentials)) {
            return ['success' => false, 'message' => 'login or password invalid'];
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
