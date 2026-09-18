<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Item;

class ArrivalRequest extends FormRequest
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
            'item_id'       => 'required|string|exists:item,item_id',
            'status'        => 'required|string',
            'supplier_id'   => 'required|string|exists:suppliers,id_supplier',
            'currency_id'   => 'required|string|exists:currencies,id_currency',
            'quantity'      => 'required|numeric',
            'date'          => 'required|date',
            'keterangan'    => 'nullable|string',
            'unit_id'       => 'required|string|exists:units,unit_id',
            'unit_price'    => 'required|numeric',
            'net_amount'    => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'item_id.exists'     => 'Selected item does not exist in the database.',
            'currency_id.exists' => 'Selected currency does not exist in the database.',
            'unit_id.exists'     => 'Selected unit does not exist in the database.',
            'supplier_id.exists' => 'Selected supplier does not exist in the database.',
        ];
    }

    /**
     * Validasi tambahan setelah rules dasar lolos:
     * pastikan unit_id benar-benar milik unit_conversion dari item yang dipilih.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $itemId = $this->input('item_id');
            $unitId = $this->input('unit_id');

            if (!$itemId || !$unitId) {
                return; // biarkan rule 'required' dasar yang menangani
            }

            $item = Item::with('unit_conversion.details')->find($itemId);

            $validUnitCodes = optional($item?->unit_conversion)->details
                ->pluck('unit_id')
                ->toArray() ?? [];

            if (!in_array($unitId, $validUnitCodes)) {
                $validator->errors()->add('unit_id', 'Selected unit is not valid for the chosen item.');
            }
        });
    }
}
