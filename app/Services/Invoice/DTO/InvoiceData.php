<?php

namespace App\Services\Invoice\DTO;

use Carbon\Carbon;

class InvoiceData
{
    /** @param ItemData[] $items */
    public function __construct(
        public int $user_id,
        public int $client_id,
        public string $title,
        public array $items,
        public string $currency = 'USD',
        public int $tax = 0,
        public int $discount = 0,
        public ?Carbon $due_date = null,
        public ?int $manual_total = null
    ) {}

    public static function from(int $userId, array $v): self {
        $items = array_map(fn($i)=>ItemData::from($i), $v['items']);
        return new self(
            user_id: $userId,
            client_id: (int)$v['client_id'],
            title: $v['title'],
            items: $items,
            currency: $v['currency'] ?? 'USD',
            tax: (int)($v['tax'] ?? 0),
            discount: (int)($v['discount'] ?? 0),
            due_date: isset($v['due_date']) ? now()->parse($v['due_date']) : null,
            manual_total: $v['manual_total'] ?? null
        );
    }

    public function subtotal(): int {
        return array_sum(array_map(fn($i)=>$i->lineTotal(), $this->items));
    }

    public function total(): int {
        if ($this->manual_total !== null) return (int)$this->manual_total;
        return max(0, $this->subtotal() + $this->tax - $this->discount);
    }

    public function itemsArray(): array {
        return array_map(fn($i)=>$i->toArray(), $this->items);
    }
}
