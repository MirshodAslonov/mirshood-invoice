<?php

namespace App\Repositories\Eloquent;

use App\Models\Invoice;

class InvoiceRepository
{
    public function create(array $data): Invoice
    {
        return Invoice::create($data);
    }
    public function update(Invoice $inv, array $data): Invoice
    {
        $inv->update($data);
        return $inv;
    }
    public function findByIdForUser(int $id, int $userId): ?Invoice
    {
        return Invoice::where('id',$id)->where('user_id',$userId)->first();
    }
    public function paginateForUser(int $userId, array $filters=[], int $perPage=15)
    {
        return Invoice::where('user_id',$userId)
            ->when($filters['status'] ?? null, fn($q,$s)=>$q->where('status',$s))
            ->latest()->paginate($perPage);
    }
}
