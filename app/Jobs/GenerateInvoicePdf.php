<?php

namespace App\Jobs;

use App\Models\Invoice;
use App\Services\Invoice\Contracts\PdfGeneratorInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerateInvoicePdf implements ShouldQueue
{
    use Queueable;

    public function __construct(public int $invoiceId) {}

    public function handle(PdfGeneratorInterface $pdf): void
    {
        $invoice = Invoice::find($this->invoiceId);
        if (!$invoice) return;

        $path = $pdf->generate($invoice);
        $invoice->update(['pdf_path' => $path]);
    }
}
