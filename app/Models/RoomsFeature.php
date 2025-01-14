<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomsFeature extends Model
{
    protected $table = 'rooms_features';

    protected $primaryKey = 'feature_id';
    protected $fillable = [
        'name',
        'description'
    ];

    public function roomsCategories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(RoomsCategory::class, 'room_category_feature', 'feature_id', 'rooms_categories_id');
    }
}
