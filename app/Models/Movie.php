<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $table = 'movies';

    public function episodes()
    {
        return $this->hasMany(Episode::class, 'movie_id');
    }
}
