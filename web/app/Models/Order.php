<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'no_spk', 'customer_id', 'unit_id', 'branch_id', 'metode', 'leasing_id',
        'dp_rencana', 'tenor', 'angsuran_estimasi', 'booking_fee', 'status',
        'deadline_at', 'bukti_path', 'bast_path', 'jadwal_serah_at', 'bast_at', 'stnk_selesai_at',
        'verified_by', 'verified_at', 'tolak_alasan',
    ];

    protected function casts(): array
    {
        return [
            'deadline_at' => 'datetime',
            'verified_at' => 'datetime',
            'jadwal_serah_at' => 'datetime',
            'bast_at' => 'datetime',
            'stnk_selesai_at' => 'datetime',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function leasing(): BelongsTo
    {
        return $this->belongsTo(LeasingPartner::class, 'leasing_id');
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function scopeAktif($query)
    {
        return $query->whereIn('status', ['MenungguBayar', 'MenungguVerifikasi']);
    }

    // Status yang dilihat pelanggan: pelunasan yang dicatat admin menang atas status internal.
    public function statusTampil(): string
    {
        return $this->invoice?->lunas_at ? 'Lunas' : $this->status;
    }
}
