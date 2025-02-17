<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'number',
        'name',
        'description',
        'rooms_category_id',
        'language_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(RoomsCategory::class, 'rooms_category_id', 'id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
