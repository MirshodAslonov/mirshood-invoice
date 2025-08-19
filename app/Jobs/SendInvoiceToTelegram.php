<?php

namespace App\Jobs;

use App\Models\Invoice;
use App\Services\Telegram\TelegramService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendInvoiceToTelegram implements ShouldQueue
{
    use Queueable;

    public function __construct(public int $invoiceId) {}

    public function handle(TelegramService $tg): void
    {
        $invoice = Invoice::with('client')->find($this->invoiceId);
        if (!$invoice || !$invoice->client->telegram_chat_id) return;

        $text = "🧾 <b>{$invoice->title}</b>\n".
            "Jami: {$invoice->total} {$invoice->currency}\n".
            "Status: {$invoice->status}\n";

        $tg->sendMessage($invoice->client->telegram_chat_id, $text);

        if ($invoice->pdf_path && file_exists($invoice->pdf_path)) {
            $tg->sendDocument($invoice->client->telegram_chat_id, $invoice->pdf_path, "Invoice #{$invoice->id}");
        }
    }
}

