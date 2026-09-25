<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceDetail extends Model
{
    protected $fillable = ['service_booking_id', 'jenis', 'deskripsi', 'qty', 'harga_satuan', 'subtotal', 'sparepart_id'];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(ServiceBooking::class, 'service_booking_id');
    }

    public function sparepart(): BelongsTo
    {
        return $this->belongsTo(Sparepart::class);
    }
}
