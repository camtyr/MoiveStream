<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class MovieController extends Controller
{
    function listMovies()
    {
        $movies = Movie::paginate(8);
        return view('movies.list', compact('movies'));
    }

    function detailMovie($slug)
    {
        $movie = Movie::with('episodes')->where("slug", $slug)->firstOrFail();

        $selectedEpisode = null;
        $episodeId = request()->input('episode'); // Lấy ID từ query string
        if ($episodeId) {
            $selectedEpisode = $movie->episodes->firstWhere('id', $episodeId); // Tìm trong collection đã eager-loaded
        }
        if (!$selectedEpisode && $movie->episodes->isNotEmpty()) {
            $selectedEpisode = $movie->episodes->first(); // Mặc định tập đầu tiên
        }

        return view('movies.detail', compact('movie', 'selectedEpisode'));
    }
}
