<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    protected $table = 'episodes';

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }
}
