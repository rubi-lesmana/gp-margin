<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitConversionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description'         => 'required|string|max:50',
            'unit_id'             => 'required|array|min:1',
            'unit_id.*'           => 'required|string|exists:units,unit_id',
            'conversion_value'    => 'required|array|min:1',
            'conversion_value.*'  => 'required|numeric|min:0.000001',
        ];
    }

    public function messages(): array
    {
        return [
            'unit_id.required'            => 'Minimal harus ada 1 baris unit.',
            'unit_id.*.exists'            => 'Unit tidak ditemukan.',
            'conversion_value.*.required' => 'Nilai konversi wajib diisi.',
            'conversion_value.*.numeric'  => 'Nilai konversi harus berupa angka.',
        ];
    }
}

?>