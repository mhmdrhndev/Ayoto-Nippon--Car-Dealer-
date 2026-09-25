<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadFollowup extends Model
{
    protected $fillable = ['lead_id', 'sales_id', 'catatan', 'next_reminder'];

    protected function casts(): array
    {
        return ['next_reminder' => 'datetime'];
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }
}
