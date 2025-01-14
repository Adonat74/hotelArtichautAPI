<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{

    use HasFactory;

    protected $fillable = [
        'url',
        'fk_content_id',
        'fk_news_id',
        'fk_service_id',
        'fk_rooms_category_id'
    ];


    public function content(): BelongsTo
    {
        return $this->belongsTo(Content::class);
    }

    public function news(): BelongsTo
    {
        return $this->belongsTo(NewsArticle::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'fk_service_id', 'service_id');
    }
}
