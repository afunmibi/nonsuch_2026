<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaMonitoring extends Model
{
    use HasFactory;

    protected $fillable = [
        'pa_code',
        'policy_no',
        'full_name',
        'phone_no',
        'diagnosis',
        'treatment_received',
        'days_spent',
        'remarks',
        'monitoring_status',
        'monitored_by',
        'file_path'
    ];

    public function logRequest(): BelongsTo
    {
        return $this->belongsTo(LogRequest::class, 'pa_code', 'pa_code');
    }

    public function monitor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'monitored_by');
    }
}
