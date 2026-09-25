<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = ['tipe', 'slug', 'judul', 'isi', 'aktif'];

    protected function casts(): array
    {
        return ['aktif' => 'boolean'];
    }
}
