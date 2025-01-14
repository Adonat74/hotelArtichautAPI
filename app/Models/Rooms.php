<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rooms extends Model
{
    protected $table = 'rooms';
    protected $primaryKey = 'rooms_id';

    protected $fillable = [
        'number',
        'description',
        'price_in_cents',
        'fk_has_rooms_categories'
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo('App\Models\RoomsCategory', 'fk_has_room_categories', 'room_categories_id');
    }
}
