<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    protected $table = 'rooms';

    protected $fillable = [
        'number',
        'description',
        'price_in_cents',
        'rooms_category_id'
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(RoomsCategory::class);
    }
}
