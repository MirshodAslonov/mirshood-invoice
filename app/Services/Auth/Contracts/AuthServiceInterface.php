<?php

namespace App\Services\Auth\Contracts;

use App\Services\Auth\DTO\RegisterData;

interface AuthServiceInterface
{
    public function register(RegisterData $data);
    public function login(array $credentials);
}
