<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SparepartOrder extends Model
{
    protected $fillable = ['no_spo', 'customer_id', 'branch_id', 'total', 'status', 'deadline_at', 'bukti_path'];

    protected function casts(): array
    {
        return ['deadline_at' => 'datetime'];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(SparepartOrderItem::class);
    }
}
