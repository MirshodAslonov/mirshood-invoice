<?php

namespace App\Services\Invoice;

use App\Events\InvoiceCreated;
use App\Models\Invoice;
use App\Repositories\Contracts\InvoiceRepositoryInterface;
use App\Services\Invoice\Contracts\PdfGeneratorInterface;
use App\Services\Invoice\DTO\InvoiceData;

class InvoiceService
{
    public function __construct(
        private InvoiceRepositoryInterface $invoices,
        private PdfGeneratorInterface $pdf
    ) {}

    public function create(InvoiceData $data): Invoice
    {
        $invoice = $this->invoices->create([
            'user_id'  => $data->user_id,
            'client_id'=> $data->client_id,
            'title'    => $data->title,
            'items'    => $data->itemsArray(),
            'currency' => $data->currency,
            'subtotal' => $data->subtotal(),
            'tax'      => $data->tax,
            'discount' => $data->discount,
            'total'    => $data->total(),
            'status'   => 'pending',
            'due_date' => $data->due_date,
        ]);

        // PDF ni generatsiya qilish (fon ishida ham qilsa bo‘ladi)
        $pdfPath = $this->pdf->generate($invoice);
        $this->invoices->update($invoice, ['pdf_path'=>$pdfPath]);

        // Event
        event(new InvoiceCreated($invoice));

        return $invoice->fresh();
    }

    public function update(Invoice $invoice, InvoiceData $data): Invoice
    {
        $updated = $this->invoices->update($invoice, [
            'title'    => $data->title,
            'items'    => $data->itemsArray(),
            'currency' => $data->currency,
            'subtotal' => $data->subtotal(),
            'tax'      => $data->tax,
            'discount' => $data->discount,
            'total'    => $data->total(),
            'due_date' => $data->due_date,
        ]);

        return $updated->fresh();
    }
}
