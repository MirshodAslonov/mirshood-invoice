<?php

namespace App\Services\Auth\DTO;

class RegisterData
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password
    ) {}

    public static function from(array $v): self {
        return new self($v['name'], $v['email'], bcrypt($v['password']));
    }

    public function toArray(): array {
        return ['name'=>$this->name,'email'=>$this->email,'password'=>$this->password];
    }
}
