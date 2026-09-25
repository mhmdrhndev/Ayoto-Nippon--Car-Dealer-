<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestDrive extends Model
{
    protected $fillable = ['customer_id', 'branch_id', 'variant_id', 'jadwal', 'status', 'catatan'];

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

    public function variant(): BelongsTo
    {
        return $this->belongsTo(Variant::class);
    }
}
