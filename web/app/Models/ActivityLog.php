<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $fillable = ['user_id', 'aksi', 'model', 'model_id', 'deskripsi'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function catat(string $aksi, ?string $model = null, ?int $model_id = null, ?string $deskripsi = null): void
    {
        self::create([
            'user_id' => auth()->id(),
            'aksi' => $aksi,
            'model' => $model,
            'model_id' => $model_id,
            'deskripsi' => $deskripsi,
        ]);
    }
}
