<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomsCategory extends Model
{
    use HasFactory;

    protected $table = 'rooms_categories';

    protected $fillable = [
        'description',
        'price_in_cents',
        'bed_size',
    ];

    public function rooms(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function features(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(RoomsFeature::class);
    }

}
