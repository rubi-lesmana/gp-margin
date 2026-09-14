<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // dd([
        //     'route_parameters' => $this->route()->parameters(),
        //     'route_name'       => $this->route()->getName(),
        //     'route_uri'        => $this->route()->uri(),
        // ]);
        $itemId = $this->route('item'); // Ambil ID item dari route parameter
        return [
            'item_id' => [
                'required',
                'max:25',
                Rule::unique('item', 'item_id')->ignore($itemId, 'item_id'),
            ],
            'description'           => 'required|max:255',
            'base_margin_id'        => 'required|exists:base_margin,id',
            'unit_id'               => 'required|exists:units,unit_id',
            'unit_conversion_id'    => 'required|exists:unit_conversions,id_unit_conversion',
            'pareto_id'             => 'required|exists:paretos,id',
        ];
    }
}