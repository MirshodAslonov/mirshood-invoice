<?php

namespace App\Repositories\Contracts;

use App\Models\Invoice;

interface InvoiceRepositoryInterface {
    public function create(array $data): Invoice;
    public function update(Invoice $inv, array $data): Invoice;
    public function findByIdForUser(int $id, int $userId): ?Invoice;
    public function paginateForUser(int $userId, array $filters=[], int $perPage=15): LengthAwarePaginator;
}
