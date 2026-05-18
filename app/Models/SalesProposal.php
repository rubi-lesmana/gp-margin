<?php

// app/Models/SalesProposal.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesProposal extends Model
{
    protected $primaryKey  = 'id_proposal';
    public    $incrementing = false;
    protected $keyType      = 'string';

    protected $fillable = [
        'id_proposal', 'customer_id', 'item_id',
        'selling_price_id','ssp_min_snapshot', 'ssp_max_snapshot',
        'proposed_price', 'price_diff', 'price_diff_pct', 'price_position',
        'is_below_ssp', 'status', 'submitted_by',
        'reviewed_by', 'rejection_note',
        'submitted_at', 'reviewed_at',
    ];

    protected $casts = [
        'is_below_ssp' => 'boolean',
        'submitted_at' => 'datetime',
        'reviewed_at'  => 'datetime',
    ];

    // ── Relasi ───────────────────────────────────────────────────
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }

    public function sellingPrice()
    {
        return $this->belongsTo(SellingPrice::class, 'selling_price_id', 'id_selling_price');
    }

    public function submittedBy()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // ── Accessor status label ────────────────────────────────────
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'approved'         => 'Approved',
            'pending_approval' => 'Pending Approval',
            'manager_approved' => 'Mgr Approved',
            'rejected'         => 'Rejected',
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'approved'         => 'badge-outline-success badge-pill',
            'pending_approval' => 'badge-outline-warning badge-pill',
            'manager_approved' => 'badge-outline-primary badge-pill',
            'rejected'         => 'badge-outline-danger badge-pill',
        };
    }

    public function getPricePositionLabelAttribute(): string
    {
        return match($this->price_position) {
            'above_max'  => 'Di atas SSP Max',
            'at_max'     => 'Sama dengan SSP Max',
            'between'    => 'Antara SSP Min & Max',
            'below_min'  => 'Di bawah SSP Min',
        };
    }

    public function getPricePositionBadgeAttribute(): string
    {
        return match($this->price_position) {
            'above_max'  => 'bg-primary',
            'at_max'     => 'bg-success',
            'between'    => 'bg-info',
            'below_min'  => 'bg-danger',
        };
    }
}