<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;


    public $primaryKey = 'service_id';

    protected $fillable = [
        'title',
        'price_in_cent',
        'duration_in_day',
        'is_per_person',
    ];

    public function photos(): HasMany
    {
        return $this->hasMany(Image::class);
    }


}
