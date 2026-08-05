<?php

namespace App\Exports;

use App\Models\ViewSalesProposalExport;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesProposalExport implements FromQuery, WithHeadings, WithMapping
{
    public function query()
    {
        return ViewSalesProposalExport::query()->orderBy('id_proposal', 'asc');
    }

    public function map($row): array
    {
        return [
            $row->id_proposal,
            $row->status,
            $row->cust_name,
            $row->days,
            $row->top_description,
            $row->item_id,
            $row->item_description,
            $row->selling_price_id,
            $row->qty_kg,
            $row->proposed_price,
            $row->minimum_price,
            $row->maximum_price,
            $row->price_diff,
            $row->price_diff_pct !== null ? $row->price_diff_pct . '%' : '-',
            $row->price_position,       
        ];
    }

    public function headings(): array
    {
        return [
            'Proposal ID',
            'Status',
            'Customer Name',
            'TOP Days',
            'TOP Description',
            'Item ID',
            'Item Description',
            'Selling Price ID',
            'Minimum Price',
            'Maximum Price',
            'Quantity (kg)',
            'Proposed Price',
            'Price Difference',
            'Price Difference (%)',
            'Price Position',
        ];
    }
}