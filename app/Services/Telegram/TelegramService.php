<?php

namespace App\Services\Telegram;

use Telegram\Bot\Api;

class TelegramService
{
    public function __construct(private Api $telegram) {}

    public function sendMessage(string $chatId, string $text): void {
        $this->telegram->sendMessage(['chat_id'=>$chatId,'text'=>$text,'parse_mode'=>'HTML']);
    }

    public function sendDocument(string $chatId, string $absPath, string $caption=''): void {
        $this->telegram->sendDocument([
            'chat_id' => $chatId,
            'document' => fopen($absPath, 'r'),
            'caption' => $caption,
        ]);
    }
}

