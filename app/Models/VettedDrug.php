<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class VettedDrug extends Model
{
    protected $fillable = [
        'pa_code', 'drug_name', 'tariff', 'qty', 'copayment_10', 
        'hcp_amount_claimed_total_drugs', 'hcp_amount_due_total_drugs', 
        'remarks', 'vetted_by', 'checked_by', 're_checked_by', 'approved_by', 'paid_by'
    ];

    // Ensures these always act like numbers in PHP
    protected $casts = [
        'tariff' => 'decimal:2',
        'hcp_amount_due_total_drugs' => 'decimal:2',
        'copayment_10' => 'decimal:2',
    ];
    public function bill()
    {
        return $this->belongsTo(BillVetting::class, 'pa_code', 'pa_code');
    }

    protected $appends = ['total_hcp_amount_claimed'];

    public function getTotalHcpAmountClaimedAttribute()
    {
        return $this->hcp_amount_claimed_total_drugs;
    }
}


