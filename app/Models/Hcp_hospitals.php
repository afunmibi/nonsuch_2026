<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hcp_hospitals extends Model
{
    protected $fillable = [
        'hcp_name',
        'hcp_code',
        'hcp_location',
        'hcp_contact',
        'hcp_email',
        'hcp_account_number',
        'hcp_account_name',
        'hcp_bank_name',
        'hcp_accreditation_status',
    ];
}
