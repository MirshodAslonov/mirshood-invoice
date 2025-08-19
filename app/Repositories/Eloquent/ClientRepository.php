<?php

namespace App\Repositories\Eloquent;

use App\Models\Client;
use App\Repositories\Contracts\ClientRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientRepository implements ClientRepositoryInterface
{
    public function create(array $data): Client
    {
        return Client::create($data);
    }
    public function update(Client $c, array $data): Client
    {
        $c->update($data);
        return $c;
    }
    public function findByIdForUser(int $id, int $userId): ?Client
    {
        return Client::where('id',$id)->where('user_id',$userId)->first();
    }
    public function paginateForUser(int $userId, int $perPage=15): LengthAwarePaginator
    {
        return Client::where('user_id',$userId)->latest()->paginate($perPage);
    }
    public function findByTelegramToken(string $token): ?Client {
        return Client::where('telegram_token',$token)->first();
    }
}

