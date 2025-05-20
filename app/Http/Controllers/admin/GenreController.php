<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genres = Genre::orderBy('id', 'desc')->paginate(perPage: 8);
        return view('admin.genres.index', compact('genres'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.genres.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:160|unique:genres',
        ]);

        $data = $request->only("name");
        $data['slug'] = Str::slug($request->name);

        $createdGenre = Genre::create($data);
        if($createdGenre) {
            return redirect()->route('genre.index')->with('success', 'Genre created successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to genre genre');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genre $genre)
    {
        return view('admin.genres.edit', compact('genre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'name' => 'required|min:2|max:160|unique:genres,name,'.$genre->id
        ]);

        $data = $request->only("name");

        $data['slug'] = Str::slug($request->name);

        if($genre->update($data)) {
            return redirect()->route('genre.index')->with('success', 'Genre updated successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to update genre');
        } 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        if ($genre->delete()) {
            return redirect()->route('genre.index')->with('success', 'Genre deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to delete genre');
        }
    }
}
