<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceBooking extends Model
{
    protected $fillable = ['no_svc', 'customer_id', 'branch_id', 'nopol', 'vin', 'km', 'keluhan', 'jadwal', 'status', 'estimasi_biaya', 'mekanik_id'];

    protected function casts(): array
    {
        return ['jadwal' => 'datetime'];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function mekanik(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mekanik_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(ServiceDetail::class);
    }

    public function total(): int
    {
        return (int) $this->details()->sum('subtotal');
    }
}
