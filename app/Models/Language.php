<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'lang',
    ];

    public function contents(): HasMany
    {
        return $this->hasMany(Content::class);
    }

    public function news(): HasMany
    {
        return $this->hasMany(NewsArticle::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function roomsCategories(): HasMany
    {
        return $this->hasMany(RoomsCategory::class);
    }

    public function roomsFeatures(): HasMany
    {
        return $this->hasMany(RoomsFeature::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
