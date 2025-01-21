<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoomsCategory extends Model
{
    use HasFactory;

    protected $table = 'rooms_categories';

    protected $hidden = ['created_at', 'updated_at', 'pivot'];

    protected $fillable = [
        'name',
        'description',
        'price_in_cent',
        'bed_size',
    ];

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class, 'rooms_category_id', 'id');
    }

    public function features(): BelongsToMany
    {
        return $this->belongsToMany(RoomsFeature::class, 'room_category_feature',  'rooms_categories_id', 'rooms_features_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

}
