<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeasingPartner extends Model
{
    protected $fillable = ['nama', 'telp', 'dp_min_persen', 'tenor_list', 'bunga_dasar', 'aktif'];

    protected function casts(): array
    {
        return ['bunga_dasar' => 'decimal:2', 'aktif' => 'boolean'];
    }
}
