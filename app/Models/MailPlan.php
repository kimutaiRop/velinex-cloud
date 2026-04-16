<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailPlan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price_kes',
        'storage_mb',
        'max_domains',
        'features',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'features'    => 'array',
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
    ];

    public function getStorageLabelAttribute(): string
    {
        if ($this->storage_mb >= 1024) {
            return ($this->storage_mb / 1024) . ' GB';
        }
        return $this->storage_mb . ' MB';
    }

    public function getMaxDomainsLabelAttribute(): string
    {
        return $this->max_domains === null ? 'Unlimited' : (string) $this->max_domains;
    }

    public function getPriceLabelAttribute(): string
    {
        return $this->price_kes === 0 ? 'Free' : 'KES ' . number_format($this->price_kes);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
