<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomsFeature extends Model
{
    use HasFactory;
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
