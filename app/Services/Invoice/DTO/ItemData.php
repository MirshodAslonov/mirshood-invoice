<?php

namespace App\Services\Invoice\DTO;

class ItemData
{
    public function __construct(
        public string $name,
        public int $price,
        public int $qty = 1
    ) {}

    public static function from(array $i): self {
        return new self($i['name'], (int)$i['price'], (int)($i['qty'] ?? 1));
    }

    public function lineTotal(): int { return $this->price * $this->qty; }

    public function toArray(): array {
        return ['name'=>$this->name,'price'=>$this->price,'qty'=>$this->qty];
    }
}
