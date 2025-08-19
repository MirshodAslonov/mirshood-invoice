<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'title'     => 'required|string|max:200',
            'items'     => 'required|array|min:1',
            'items.*.name'  => 'required|string|max:200',
            'items.*.price' => 'required|integer|min:0',
            'items.*.qty'   => 'nullable|integer|min:1',
            'currency'  => 'nullable|string|max:8',
            'tax'       => 'nullable|integer|min:0',
            'discount'  => 'nullable|integer|min:0',
            'due_date'  => 'nullable|date',
            // Agar foydalanuvchi o‘zi total kiritmoqchi bo‘lsa:
            'manual_total' => 'nullable|integer|min:0',
        ];
    }
}
class InvoiceUpdateRequest extends InvoiceStoreRequest { /* same */ }
