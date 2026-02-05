<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillVetting extends Model
{
    // Explicitly tell Laravel to use the singular table name from your migration
    protected $table = 'billvetting';

   protected $fillable = [
    'pa_code',
    'full_name',
    'policy_no',
    'dob',
    'phone_no',
    'package_code',
    'package_price',
    'package_limit',
    'pry_hcp',
    'pry_hcp_code',
    'sec_hcp',      
    'sec_hcp_code', 
    'sec_hcp_bank_name',
    'sec_hcp_account_number',
    'sec_hcp_account_name',
    'hcp_contact',
    'hcp_email',
    'diagnosis',
    'treatment_plan',
    'further_investigation',
    'log_request_id',
    'billing_month',
    'admission_date',
    'discharge_date',
    'admission_days',
    'hcp_amount_due_grandtotal',
    'hcp_amount_claimed_grandtotal',
    'vetted_by',
    'pa_code_approved_by',
    'checked_by',
    're_checked_by',
    'approved_by',
    'scheduled_for_payment_by',
    'paid_by',
    'status',
    'staff_vetted_at',
    'checked_at',
    're_checked_at',
    'authorized_at',
    'cm_processed_at',
    'paid_at'
];
public function services()
{
    return $this->hasMany(VettedService::class, 'pa_code', 'pa_code');
}

public function drugs()
{
    return $this->hasMany(VettedDrug::class, 'pa_code', 'pa_code');
}

public function logRequest()
{
    return $this->belongsTo(LogRequest::class, 'pa_code', 'pa_code');
}

    public function monitoring(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(PaMonitoring::class, 'pa_code', 'pa_code');
    }
}