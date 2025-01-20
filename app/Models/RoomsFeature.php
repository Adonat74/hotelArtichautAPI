<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RoomsFeature extends Model
{
    use HasFactory;
    protected $table = 'rooms_features';

    protected $hidden = ['created_at', 'updated_at', 'pivot'];

    protected $fillable = [
        'name',
        'description'
    ];

    public function roomsCategories(): BelongsToMany
    {
        return $this->belongsToMany(RoomsCategory::class, 'room_category_feature',  'rooms_features_id','rooms_categories_id', );
    }
}
