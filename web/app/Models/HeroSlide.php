<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $fillable = ['nama', 'foto', 'urutan', 'aktif'];

    protected function casts(): array
    {
        return ['aktif' => 'boolean'];
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    public function scopeTerurut($query)
    {
        return $query->orderBy('urutan')->orderBy('id');
    }
}
