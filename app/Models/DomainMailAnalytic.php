<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DomainMailAnalytic extends Model
{
    protected $fillable = [
        'domain_id',
        'metric_date',
        'sent_count',
        'received_count',
    ];

    protected $casts = [
        'metric_date' => 'date',
    ];

    public function domain(): BelongsTo
    {
        return $this->belongsTo(Domain::class);
    }
}

