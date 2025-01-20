<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'rate',
        'review_content',
        'user_id',
    ];
   /* public function user(){
        return $this->belongsTo(Users::class);
    }*/
}
