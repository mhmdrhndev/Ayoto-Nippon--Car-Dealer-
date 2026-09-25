<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    protected $fillable = ['customer_id', 'sales_id', 'sumber', 'status', 'kebutuhan_text', 'followup_at'];

    protected function casts(): array
    {
        return ['followup_at' => 'datetime'];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function sales(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sales_id');
    }

    public function followups(): HasMany
    {
        return $this->hasMany(LeadFollowup::class);
    }
}
