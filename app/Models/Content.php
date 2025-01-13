<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    /** @use HasFactory<\Database\Factories\ContentFactory> */
    use HasFactory;

    protected $primaryKey = 'flight_id';


    protected $fillable = [
        'name',
        'title',
        'short_description',
        'description',
        'landing_page_display',
        'navbar_display',
        'link',
    ];
}
