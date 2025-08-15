<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = AuthService::register($request->validated());
        return success($data);
    }

    public function login(LoginRequest $request)
    {
        $data = AuthService::login($request->validated());
        return success($data);
    }
}
