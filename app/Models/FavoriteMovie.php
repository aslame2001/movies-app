<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteMovie extends Model
{

    protected $fillable = [
        'user_id',
        'movie_title',
        'movie_id',
        'poster_url',
    ];

    protected $dates = [
        'added_at',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
