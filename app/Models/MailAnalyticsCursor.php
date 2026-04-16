<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailAnalyticsCursor extends Model
{
    protected $fillable = [
        'source_key',
        'file_path',
        'last_position',
        'file_fingerprint',
        'last_processed_at',
    ];

    protected $casts = [
        'last_processed_at' => 'datetime',
    ];
}

