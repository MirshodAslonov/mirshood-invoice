<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\AuthService;
use App\Services\Auth\Contracts\AuthServiceInterface;
use App\Services\Auth\DTO\RegisterData;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthServiceInterface $auth) {}

    public function register(RegisterRequest $request) {
        $data = RegisterData::from($request->validated());
        return success($this->auth->register($data));
    }

    public function login(LoginRequest $request) {
        return success($this->auth->login($request->validated()));
    }

    public function me() { return success(auth()->user()); }
    public function logout() {
        $user = auth()->user();
        $user?->currentAccessToken()?->delete();
        return success(['message'=>'Logged out']);
    }
}
