<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Unit extends Model
{
    protected $fillable = ['vin', 'variant_id', 'color_id', 'branch_id', 'status', 'tahun_rakit', 'harga', 'foto_utama'];

    public function variant(): BelongsTo
    {
        return $this->belongsTo(Variant::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function scopeTersedia($query)
    {
        return $query->where('status', 'Tersedia');
    }
}
