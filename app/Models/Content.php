<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Content extends Model
{
    use HasFactory;

    protected $primaryKey = 'content_id';


    protected $fillable = [
        'name',
        'title',
        'short_description',
        'description',
        'landing_page_display',
        'navbar_display',
        'link',
    ];

    public function photos(): HasMany
    {
        return $this->hasMany(Image::class);
    }
}
