<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at'];


    protected $fillable = [
        'title',
        'price_in_cent',
        'duration_in_day',
        'is_per_person',
        'language_id',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
