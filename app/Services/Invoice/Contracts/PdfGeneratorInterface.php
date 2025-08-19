<?php

namespace App\Services\Invoice\Contracts;

use App\Models\Invoice;

interface PdfGeneratorInterface
{
    public function generate(Invoice $invoice): string;
}
