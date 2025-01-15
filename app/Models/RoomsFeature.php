<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomsFeature extends Model
{
    protected $table = 'rooms_features';

    protected $fillable = [
        'name',
        'description'
    ];

    public function roomsCategories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(RoomsCategory::class);
    }
}
