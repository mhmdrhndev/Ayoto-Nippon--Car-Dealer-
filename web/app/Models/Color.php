<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Color extends Model
{
    protected $fillable = ['nama', 'kode_hex', 'aktif'];

    protected function casts(): array
    {
        return ['aktif' => 'boolean'];
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }
}
