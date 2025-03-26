<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'name',
        'number',
        'room_name',
        'description',
        'rooms_category_id',
        'display_order',
        'language_id',
    ];

    protected $appends = ['is_available'];

    public function getIsAvailableAttribute(): bool
    {
        $now = Carbon::now();
        $hasActiveBooking = $this->bookings()
            ->where('check_in', '<', $now)
            ->where('check_out', '>=', $now)
            ->get();

        return $hasActiveBooking->isEmpty();
    }

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

    public function bookings(): BelongsToMany
    {
        return $this->belongsToMany(Booking::class);
    }
}
