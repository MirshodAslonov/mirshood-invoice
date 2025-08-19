<?php

namespace App\Repositories\Contracts;

use App\Models\Client;
use Illuminate\Pagination\LengthAwarePaginator;

interface ClientRepositoryInterface {
    public function create(array $data): Client;
    public function update(Client $c, array $data): Client;
    public function findByIdForUser(int $id, int $userId): ?Client;
    public function paginateForUser(int $userId, int $perPage=15): LengthAwarePaginator;
    public function findByTelegramToken(string $token): ?Client;
}
