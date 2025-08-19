<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\ClientRepositoryInterface;
use App\Services\Client\ClientService;
use Illuminate\Http\Request;

class TelegramWebhookController extends Controller
{
    public function __invoke(Request $request, ClientRepositoryInterface $clients, ClientService $service)
    {
        $update = $request->all();

        // /start <token>
        $message = $update['message'] ?? null;
        if (!$message) return response()->json(['ok'=>true]);

        $text = $message['text'] ?? '';
        $chatId = (string)($message['chat']['id'] ?? '');

        if (str_starts_with($text, '/start')) {
            $parts = explode(' ', $text);
            $token = $parts[1] ?? null;

            if ($token) {
                $client = $clients->findByTelegramToken($token);
                if ($client) {
                    $service->linkTelegramChat($client, $chatId);
                    // javob qaytarish (bevosita telegramga sendMessage service orqali ham)
                }
            }
        }

        return response()->json(['ok'=>true]);
    }
}

