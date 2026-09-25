<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PriceList extends Model
{
    protected $fillable = ['variant_id', 'branch_id', 'otr', 'bbn', 'diskon', 'berlaku_dari', 'berlaku_sampai'];

    public function variant(): BelongsTo
    {
        return $this->belongsTo(Variant::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}
