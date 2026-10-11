<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    protected $fillable = ['no_inv', 'order_id', 'total', 'pdf_path', 'lunas_pdf_path', 'lunas_at'];

    protected function casts(): array
    {
        return ['lunas_at' => 'datetime'];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
