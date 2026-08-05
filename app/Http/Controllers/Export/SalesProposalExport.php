<?php

namespace App\Http\Controllers\Export;

use App\Exports\SalesProposalExport as ExportsSalesProposalExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class SalesProposalExport extends Controller
{
    public function export()
    {
        return Excel::download(new ExportsSalesProposalExport, 'sales_proposal.xlsx');
    }
}