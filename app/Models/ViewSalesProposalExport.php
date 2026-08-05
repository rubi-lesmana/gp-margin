<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewSalesProposalExport extends Model
{
    protected $table = 'view_sales_proposal_exports';
    public $timestamps = false;
    protected $guarded = [];

    public  function save(array $options = [])
    {
        throw new \Exception("This model is read-only and cannot be saved.");
    }
}