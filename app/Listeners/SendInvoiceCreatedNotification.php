<?php
namespace App\Listeners;

use App\Events\InvoiceCreated;
use App\Jobs\GenerateInvoicePdf;
use App\Jobs\SendInvoiceToTelegram;

class SendInvoiceCreatedNotification
{
    public function handle(InvoiceCreated $event): void
    {
        $invoice = $event->invoice;

        // Agar PDF hali yo'q bo'lsa — Generate (optional, biz create() ichida qildik)
        // dispatch(new GenerateInvoicePdf($invoice->id));

        // Agar client’da chat_id bor bo‘lsa — Telegramga yuboramiz
        if ($invoice->client->telegram_chat_id) {
            dispatch(new SendInvoiceToTelegram($invoice->id));
        }
    }
}

