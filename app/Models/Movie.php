<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $table = 'movies';
    protected $fillable = [
        'title',
        'slug',
        'description',
        'status',
        'release_year',
        'thumbnail',
    ];

    public function episodes()
    {
        return $this->hasMany(Episode::class, 'movie_id')->orderBy('episode_number');;
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'genre_movie', 'movie_id', 'genre_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }
}
