<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    protected $table = 'episodes';

    protected $fillable = [
        'title',
        'episode_number',
        'movie_id'
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }
}
