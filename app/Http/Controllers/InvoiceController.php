<?php

namespace App\Http\Controllers;

use App\Events\InvoiceStatusUpdated;
use App\Http\Requests\Invoice\InvoiceStoreRequest;
use App\Http\Requests\Invoice\InvoiceUpdateRequest;
use App\Models\Invoice;
use App\Repositories\Contracts\InvoiceRepositoryInterface;
use App\Services\Invoice\DTO\InvoiceData;
use App\Services\Invoice\InvoiceService;

class InvoiceController extends Controller
{
    public function __construct(
        private InvoiceService $service,
        private InvoiceRepositoryInterface $invoices
    ) {}

    public function index() {
        return success($this->invoices->paginateForUser(auth()->id(), request()->only('status')));
    }

    public function store(InvoiceStoreRequest $request) {
        $dto = InvoiceData::from(auth()->id(), $request->validated());
        return success($this->service->create($dto));
    }

    public function show(Invoice $invoice) {
        abort_unless($invoice->user_id === auth()->id(), 403);
        return success($invoice);
    }

    public function update(InvoiceUpdateRequest $request, Invoice $invoice) {
        abort_unless($invoice->user_id === auth()->id(), 403);
        $dto = InvoiceData::from(auth()->id(), $request->validated());
        return success($this->service->update($invoice, $dto));
    }

    public function setStatus(Invoice $invoice) {
        abort_unless($invoice->user_id === auth()->id(), 403);
        $status = request('status'); // pending|paid|overdue
        abort_unless(in_array($status, ['pending','paid','overdue'], true), 422);
        $invoice->update(['status'=>$status]);
        event(new InvoiceStatusUpdated($invoice));
        return success($invoice->fresh());
    }
}

