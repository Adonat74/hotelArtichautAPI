<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{

    use HasFactory;

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'url',
        'content_id',
        'news_article_id',
        'service_id',
        'rooms_category_id',
        'room_id',
        'language_id',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

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
        return $this->belongsTo(Service::class);
    }

    public function roomsCategory(): BelongsTo
    {
        return $this->belongsTo(RoomsCategory::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
