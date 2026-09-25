<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Promo extends Model
{
    protected $fillable = ['branch_id', 'judul', 'slug', 'banner', 'deskripsi', 'mulai', 'selesai', 'aktif'];

    protected function casts(): array
    {
        return ['mulai' => 'date', 'selesai' => 'date', 'aktif' => 'boolean'];
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function scopeBerjalan($query)
    {
        return $query->where('aktif', true)
            ->whereDate('mulai', '<=', today())
            ->whereDate('selesai', '>=', today());
    }
}
