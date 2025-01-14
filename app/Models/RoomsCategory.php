<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomsCategory extends Model
{
    use HasFactory;

    protected $table = 'rooms_categories';
    protected $primaryKey = 'rooms_categories_id';

    protected $fillable = [
        'description',
        'price_in_cents',
        'bed_size',
    ];

    public function rooms(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany('App\Models\Rooms', 'fk_has_room_categories', 'rooms_category_id');
    }

    public function features(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(RoomsFeature::class, 'room_category_feature', 'room_category_id', 'feature_id');
    }

}
