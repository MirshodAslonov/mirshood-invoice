<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\ClientStoreRequest;
use App\Http\Requests\Client\ClientUpdateRequest;
use App\Models\Client;
use App\Repositories\Contracts\ClientRepositoryInterface;
use App\Services\Client\ClientService;

class ClientController extends Controller
{
    public function __construct(
        private ClientService $service,
        private ClientRepositoryInterface $clients
    ) {}

    public function index() {
        return success($this->clients->paginateForUser(auth()->id()));
    }

    public function store(ClientStoreRequest $request) {
        return success($this->service->create(auth()->id(), $request->validated()));
    }

    public function show(Client $client) {
        abort_unless($client->user_id === auth()->id(), 403);
        return success($client);
    }

    public function update(ClientUpdateRequest $request, Client $client) {
        abort_unless($client->user_id === auth()->id(), 403);
        return success($this->service->update($client, $request->validated()));
    }

    public function linkToken(Client $client) {
        abort_unless($client->user_id === auth()->id(), 403);
        // unique token allaqachon bor (create paytida). Ko'rsatamiz:
        $bot = config('services.telegram.bot_username'); // .env da saqlang
        $link = "https://t.me/{$bot}?start={$client->telegram_token}";
        return success(['link'=>$link]);
    }
}

