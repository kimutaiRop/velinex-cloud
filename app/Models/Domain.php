<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Domain extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'domain',
        'status',
        'verification_token',
        'verified_at',
        'iredmail_provisioned',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'iredmail_provisioned' => 'boolean',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function dnsRecords(): HasMany
    {
        return $this->hasMany(DomainDnsRecord::class);
    }

    public function mailboxes(): HasMany
    {
        return $this->hasMany(Mailbox::class);
    }

    public function analytics(): HasMany
    {
        return $this->hasMany(DomainMailAnalytic::class);
    }
}

