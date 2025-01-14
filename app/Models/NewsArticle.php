<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsArticle extends Model
{
    use HasFactory;

    protected $primaryKey = 'news_article_id';

    protected $fillable = [
        'title',
        'short_description',
        'description',
    ];

}
