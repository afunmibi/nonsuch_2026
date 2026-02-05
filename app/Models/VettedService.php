<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VettedService extends Model
{
    
protected $fillable = [
    'pa_code', 
    'service_name', 
    'tariff', 
    'qty', 
    'hcp_amount_due_total_services', 
    'hcp_amount_claimed_total_services', 
    'remarks', 
    'vetted_by',
    'checked_by',
    're_checked_by',
    'approved_by',
    'paid_by'
];
    protected $appends = ['total_hcp_amount_claimed'];

    public function bill()
    {
        return $this->belongsTo(BillVetting::class, 'pa_code', 'pa_code');
    }

    public function getTotalHcpAmountClaimedAttribute()
    {
        return $this->hcp_amount_claimed_total_services;
    }
}
