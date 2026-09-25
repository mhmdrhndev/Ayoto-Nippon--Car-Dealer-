<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    protected $fillable = ['nama', 'slug', 'logo', 'aktif'];

    protected function casts(): array
    {
        return ['aktif' => 'boolean'];
    }

    public function carModels(): HasMany
    {
        return $this->hasMany(CarModel::class);
    }

    public function getLogoUrlAttribute(): string
    {
        if ($this->logo && file_exists(public_path($this->logo))) {
            return asset($this->logo);
        }
        if (file_exists(public_path("images/brands/{$this->slug}.png"))) {
            return asset("images/brands/{$this->slug}.png");
        }
        if (file_exists(public_path("images/brands/{$this->slug}.svg"))) {
            return asset("images/brands/{$this->slug}.svg");
        }
        return asset('images/logo-an.png');
    }
}
