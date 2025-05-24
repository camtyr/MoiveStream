<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Episode;
use App\Models\Movie;
use Illuminate\Http\Request;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use FFMpeg\Format\Video\X264;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Exporters\HLSVideoFilters;
use Illuminate\Validation\Rule;

class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $episodes = Episode::orderBy('movie_id', 'desc')
            ->orderBy('episode_number', 'asc')
            ->paginate(8);
        return view('admin.episodes.index', compact('episodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $movies = Movie::orderBy('title', 'ASC')->select('id', 'title')->get();
        return view('admin.episodes.create', compact('movies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'title' => 'required|string|min:1|max:255',
            'episode_number' => [
                'required',
                'integer',
                Rule::unique('episodes')->where(function ($query) use ($request) {
                    return $query->where('movie_id', $request->movie_id);
                })
            ],
            'video' => 'required|file|mimes:mp4',
        ]);

        $movie = Movie::findOrFail($request->movie_id);
        $data = $request->only("title", "episode_number", "movie_id");

        if (request()->hasFile("video")) {
            $hlsPath = "{$movie->slug}/ep_{$request->episode_number}";

            Storage::disk('uploads')->putFileAs("{$hlsPath}/raw", $request->file('video'), "movie.mp4");

            $this->convertToHLS($hlsPath);
        }

        $createdEpisode = Episode::create($data);
        if ($createdEpisode) {
            return redirect()->route('episode.index')->with('success', 'Episode created successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to create episode');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Episode $episode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Episode $episode)
    {
        $movies = Movie::orderBy('title', 'ASC')->select('id', 'title')->get();
        return view('admin.episodes.edit', compact('movies', 'episode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Episode $episode)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'title' => 'required|string|min:1|max:255',
            'episode_number' => [
                'required',
                'integer',
                Rule::unique('episodes')->where(function ($query) use ($request) {
                    return $query->where('movie_id', $request->movie_id);
                })->ignore($episode->id)
            ],
            'video' => 'nullable|file|mimes:mp4',
        ]);

        $movie = Movie::findOrFail($request->movie_id);
        $data = $request->only("title", "episode_number", "movie_id");

        $oldPath = "{$episode->movie->slug}/ep_{$episode->episode_number}";
        $hlsPath = "{$movie->slug}/ep_{$request->episode_number}";

        if (!$request->hasFile('video') && ($oldPath !== $hlsPath)) {
            if (Storage::disk('uploads')->exists($oldPath)) {
                $files = Storage::disk('uploads')->allFiles($oldPath);
                foreach ($files as $file) {
                    $newFilePath = $hlsPath . '/' . ltrim(substr($file, strlen($oldPath)), '/');
                    Storage::disk('uploads')->put($newFilePath, Storage::disk('uploads')->get($file));
                }
                
                Storage::disk('uploads')->deleteDirectory($oldPath);
            }
        }

        if (request()->hasFile("video")) {
            Storage::disk('uploads')->deleteDirectory("{$episode->movie->slug}/ep_{$episode->episode_number}");

            Storage::disk('uploads')->putFileAs("{$hlsPath}/raw", $request->file('video'), "movie.mp4");

            $this->convertToHLS($hlsPath);
        }

        if ($episode->update($data)) {
            return redirect()->route('episode.index')->with('success', 'Episode updated successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to update episode');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Episode $episode)
    {
        if ($episode->delete()) {
            Storage::disk('uploads')->deleteDirectory("{$episode->movie->slug}/ep_{$episode->episode_number}");

            return redirect()->route('episode.index')->with('success', 'Episode deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to delete episode');
        }
    }

    function convertToHLS($hlsPath)
    {
        $lowBitrate = (new X264)->setKiloBitrate(250);
        $midBitrate = (new X264)->setKiloBitrate(500);
        $highBitrate = (new X264)->setKiloBitrate(1000);

        FFMpeg::fromDisk('uploads')
            ->open("{$hlsPath}/raw/movie.mp4")
            ->exportForHLS()
            ->withRotatingEncryptionKey(function ($filename, $contents) use ($hlsPath) {
                Storage::disk('uploads')->put("{$hlsPath}/secrets/{$filename}", $contents);
            })
            ->setSegmentLength(300)
            ->addFormat($lowBitrate, function (HLSVideoFilters $filters) {
                $filters->resize(480, 360);
            })
            ->addFormat($midBitrate, function (HLSVideoFilters $filters) {
                $filters->resize(1280, 720);
            })
            ->addFormat($highBitrate, function (HLSVideoFilters $filters) {
                $filters->resize(1920, 1080);
            })
            ->toDisk('uploads')
            ->save("{$hlsPath}/movies/index.m3u8");
    }
}
