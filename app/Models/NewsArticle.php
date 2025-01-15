<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewsArticle extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'short_description',
        'description',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }
}
