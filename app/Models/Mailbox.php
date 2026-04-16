<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mailbox extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain_id',
        'client_id',
        'email',
        'display_name',
        'quota_mb',
        'password_mode',
        'secondary_email',
        'require_initial_reset',
        'password_shared_at',
        'last_password_reset_at',
        'password_delivery_status',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'require_initial_reset' => 'boolean',
        'password_shared_at' => 'datetime',
        'last_password_reset_at' => 'datetime',
    ];

    public function domain(): BelongsTo
    {
        return $this->belongsTo(Domain::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function analytics(): HasMany
    {
        return $this->hasMany(MailboxMailAnalytic::class);
    }
}

