<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TradeIn extends Model
{
    protected $fillable = ['customer_id', 'order_id', 'merk_tipe', 'tahun', 'km', 'foto_paths', 'status', 'harga_penawaran'];

    protected function casts(): array
    {
        return ['foto_paths' => 'array'];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
