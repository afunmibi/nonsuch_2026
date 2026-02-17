<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrolment extends Model
{
    protected $fillable = [
        'policy_no', 'organization_name', 'full_name', 'phone_no', 'email',
        'dob', 'address', 'location', 'photograph', 'package_code',
        'package_description', 'package_price', 'package_limit', 'pry_hcp',
        // Dependants 1-4...
        'dependants_1_name', 'dependants_1_dob', 'dependants_1_photograph', 'dependants_1_status',
        'dependants_2_name', 'dependants_2_dob', 'dependants_2_photograph', 'dependants_2_status',
        'dependants_3_name', 'dependants_3_dob', 'dependants_3_photograph', 'dependants_3_status',
        'dependants_4_name', 'dependants_4_dob', 'dependants_4_photograph', 'dependants_4_status',
    ];

    /**
     * Relationship to medical requests.
     */
    public function logRequests()
    {
        return $this->hasMany(LogRequest::class, 'policy_no', 'policy_no');
    }

    /**
     * Relationship to vetted bills.
     */
    public function billVettings()
    {
        return $this->hasMany(BillVetting::class, 'policy_no', 'policy_no');
    }

    /**
     * Calculate Utilization Rate (Spent / Limit * 100)
     */
    public function getUtilizationRateAttribute()
    {
        if (!$this->package_limit || $this->package_limit <= 0) {
            return 0;
        }

        $totalSpent = $this->billVettings()->sum('hcp_amount_due_grandtotal');
        
        return round(($totalSpent / $this->package_limit) * 100, 2);
    }

    /**
     * Get total amount utilized/spent
     */
    public function getTotalUtilizedAttribute()
    {
        return $this->billVettings()->sum('hcp_amount_due_grandtotal');
    }

    /**
     * Get remaining balance (package_limit - total_utilized)
     */
    public function getRemainingBalanceAttribute()
    {
        return $this->package_limit - $this->total_utilized;
    }

    /**
     * Check if utilization is high (>80%)
     */
    public function isHighUtilization()
    {
        return $this->utilization_rate >= 80;
    }
}
