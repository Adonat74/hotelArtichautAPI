<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;
    protected $table = 'rooms';

    protected $fillable = [
        'number',
        'name',
        'description',
        'rooms_category_id'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(RoomsCategory::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }
}
