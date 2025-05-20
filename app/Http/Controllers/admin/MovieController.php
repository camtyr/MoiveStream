<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movies = Movie::orderBy('id', 'desc')->paginate(perPage: 8);
        return view('admin.movies.index', compact('movies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genres = Genre::orderBy('name', 'ASC')->select('id', 'name')->get();
        return view('admin.movies.create', compact('genres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:2|max:160|unique:movies',
            'release_year' => 'nullable|required|integer',
            'thumbnail' => 'nullable|file|mimes:jpeg,png,jpg,gif',
            'genres.*' => 'exists:genres,id'
        ]);

        $data = $request->only("title", "description", "status", "release_year");

        $data['slug'] = Str::slug($request->title);

        if (request()->hasFile("thumbnail")) {
            $thumb_name = $request->thumbnail->hashName();
            $request->thumbnail->move(public_path("assets/images/thumbnails"), $thumb_name);
            $data['thumbnail'] = $thumb_name;
        }
        
        $createdMovie = Movie::create($data);
        if($createdMovie) {
            $createdMovie->genres()->sync($request->input('genres', []));
            return redirect()->route('movie.index')->with('success', 'Movie created successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to create movie');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        $genres = Genre::orderBy('name', 'ASC')->select('id', 'name')->get();
        return view('admin.movies.edit', compact('genres', 'movie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {
         $request->validate([
            'title' => 'required|min:2|max:160|unique:movies,title,'.$movie->id,
            'release_year' => 'nullable|required|integer',
            'thumbnail' => 'nullable|file|mimes:jpeg,png,jpg,gif',
            'genres.*' => 'exists:genres,id'
        ]);

        $data = $request->only("title", "description", "status", "release_year");

        $data['slug'] = Str::slug($request->title);

        if (request()->hasFile("thumbnail")) {
            $thumb_oldname = $movie->thumbnail;

            $thumb_path = public_path("assets/images/thumbnails/{$thumb_oldname}");
            if (file_exists($thumb_path) && $thumb_oldname != null) {
                unlink($thumb_path);
            }

            $thumb_name = $request->thumbnail->hashName();
            $request->thumbnail->move(public_path("assets/images/thumbnails"), $thumb_name);
            $data['thumbnail'] = $thumb_name;
        }
        
        if($movie->update($data)) {
            $movie->genres()->sync($request->input('genres', []));
            return redirect()->route('movie.index')->with('success', 'Movie updated successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to update movie');
        } 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        if ($movie->delete()) {
            $thumb_name = $movie->thumbnail;

            $thumb_path = public_path("assets/images/thumbnails/{$thumb_name}");
            if (file_exists($thumb_path) && $thumb_name != null) {
                unlink($thumb_path);
            }
            return redirect()->route('movie.index')->with('success', 'Movie deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to delete movie');
        }
    }
}
