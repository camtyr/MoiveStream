<?php

namespace App\Http\Controllers;

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

    function detailMovie($slug)
    {
        $movie = Movie::with('episodes')->where("slug", $slug)->firstOrFail();

        $selectedEpisode = null;
        $episodeId = request()->input('episode');
        if ($episodeId) {
            $selectedEpisode = $movie->episodes->firstWhere('id', $episodeId);
        }
        if (!$selectedEpisode && $movie->episodes->isNotEmpty()) {
            $selectedEpisode = $movie->episodes->first();
        }

        return view('movies.detail', compact('movie', 'selectedEpisode'));
    }

    function getMovie($slug, $filename)
    {
        $this->folder = $slug;
        return FFMpeg::dynamicHLSPlaylist("uploads")
            ->fromDisk('uploads')
            ->open("{$this->folder}/movies/{$filename}")
            ->setKeyUrlResolver(function ($key) {
                return route('movie.key', ['folder' => $this->folder, 'key' => $key]);
            })
            ->setMediaUrlResolver(function ($media) {
                return route('movie.media', ['folder' => $this->folder, 'media' => $media]);
            })
            ->setPlaylistUrlResolver(function ($playlist) {
                return route('movie.playlist', ['folder' => $this->folder, 'playlist' => $playlist]);
            });
    }

    function getKey($folder, $key)
    {
        $path = Storage::disk('uploads')->path("{$folder}/secrets/{$key}");
        return response()->download($path);
    }

    function getFile($folder, $file)
    {
        $path = Storage::disk('uploads')->path("{$folder}/movies/{$file}");
        return response()->download($path);
    }
}
