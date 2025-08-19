<?php

namespace App\Services\Client;

use App\Models\Client;
use App\Repositories\Contracts\ClientRepositoryInterface;
use Illuminate\Support\Str;

class ClientService
{
    public function __construct(private ClientRepositoryInterface $clients) {}

    public function create(int $userId, array $data): Client
    {
        $data['user_id'] = $userId;
        $data['telegram_token'] = Str::random(24); // unique /start token
        return $this->clients->create($data);
    }

    public function update(Client $client, array $data): Client
    {
        return $this->clients->update($client, $data);
    }

    public function linkTelegramChat(Client $client, string $chatId): Client
    {
        return $this->clients->update($client, ['telegram_chat_id'=>$chatId]);
    }
}
