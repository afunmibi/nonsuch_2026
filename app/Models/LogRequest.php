<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogRequest extends Model
{
    protected $fillable = [
        'staff_id', 'pa_code', 'policy_no', 'full_name', 'phone_no', 'dob',
        'pry_hcp', 'pry_hcp_code', 'sec_hcp', 'sec_hcp_code',
        'package_code', 'package_description', 'package_price', 'package_limit',
        'diagnosis', 'diag_code', 'treatment_plan', 'further_investigation',
        'pa_code_status', 'pa_code_approved_by', 'vetted_by', 'checked_by', 're_checked_by', 'approved_by', 'paid_by', 'scheduled_for_payment_by',
        'hcp_amount_claimed_grandtotal', 'hcp_amount_due_grandtotal', 'hcp_contact', 'hcp_email'
    ];

    /**
     * Relationship to the staff member who created the request.
     */
    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    /**
     * Relationship to the package details.
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_code', 'package_code');
    }
    public function monitoring(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(PaMonitoring::class, 'pa_code', 'pa_code');
    }
}