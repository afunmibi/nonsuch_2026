<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HcpBillUpload extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'hcp_name',
        'hcp_code',
        'billing_month',
        'hmo_officer',
        'amount_claimed',
        'file_path',
        'status',
        'remarks',
        'hcp_id'
    ];

    /**
     * Relationship to the user who uploaded the bill.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
