<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MailboxMailAnalytic extends Model
{
    protected $fillable = [
        'mailbox_id',
        'metric_date',
        'sent_count',
        'received_count',
    ];

    protected $casts = [
        'metric_date' => 'date',
    ];

    public function mailbox(): BelongsTo
    {
        return $this->belongsTo(Mailbox::class);
    }
}

