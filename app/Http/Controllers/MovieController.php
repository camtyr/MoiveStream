<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{
    function listMovies()
    {
        $movies = Movie::paginate(8);
        return view('movies.list', compact('movies'));
    }
}