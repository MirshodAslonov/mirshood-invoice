<?php

namespace App\Services\Invoice\Pdf;

use App\Models\Invoice;
use App\Services\Invoice\Contracts\PdfGeneratorInterface;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class DompdfGenerator implements PdfGeneratorInterface
{
    public function generate(Invoice $invoice): string
    {
        $pdf = Pdf::loadView('pdf.invoice', ['invoice'=>$invoice]);
        $path = "invoices/{$invoice->id}.pdf";
        Storage::disk('public')->put($path, $pdf->output());
        return Storage::disk('public')->path($path);
    }
}
