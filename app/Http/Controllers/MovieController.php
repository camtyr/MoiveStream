<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{

    private $folder;

    function listMovies()
    {
        $movies = Movie::paginate(8);
        return view('movies.list', compact('movies'));
    }

    function detailMovie($slug, Request $request)
    {
        $movie = Movie::with('episodes')->where("slug", $slug)->firstOrFail();

        $selectedEpisode = null;
        if ($request->has('episode')) {
            $selectedEpisode = $movie->episodes->firstWhere('id', $request->episode);
        }

        if (!$selectedEpisode && $movie->episodes->isNotEmpty()) {
            $selectedEpisode = $movie->episodes->sortBy('episode_number')->first();
        }


        return view('movies.detail', compact('movie', 'selectedEpisode'));
    }

    function getMovie($slug, $episode_number, $filename)
    {
        $this->folder = "{$slug}/ep_{$episode_number}";
        
        return FFMpeg::dynamicHLSPlaylist("uploads")
            ->fromDisk('uploads')
            ->open("{$this->folder}/movies/{$filename}")
            ->setKeyUrlResolver(function ($key) use ($slug, $episode_number) {
                return route('movie.key', ['slug' => $slug, "episode_number" => $episode_number, 'key' => $key]);
            })
            ->setMediaUrlResolver(function ($media) use ($slug, $episode_number) {
                return route('movie.media', ['slug' => $slug, "episode_number" => $episode_number, 'media' => $media]);
            })
            ->setPlaylistUrlResolver(function ($playlist) use ($slug, $episode_number): string {
                return route('movie.playlist', ['slug' => $slug, "episode_number" => $episode_number, 'playlist' => $playlist]);
            });
    }

    function getKey($slug, $episode_number, $key)
    {
        $path = Storage::disk('uploads')->path("{$slug}/ep_{$episode_number}/secrets/{$key}");
        return response()->download($path);
    }

    function getMedia($slug, $episode_number, $media)
    {
        $path = Storage::disk('uploads')->path("{$slug}/ep_{$episode_number}/movies/{$media}");
        return response()->download($path);
    }
}
