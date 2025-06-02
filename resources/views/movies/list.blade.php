@extends('layouts.app')

@section('title', 'List Movies')

@section('content')
<section>
    <div class="container" style="max-width: 1200px">
        <div class="row pt-5 d-flex">
            <form method="GET" action="{{ route('movie.list') }}" class="mb-4 row g-2 justify-content-center">
                <input type="hidden" name="title" value="{{ request('title') }}">

                <div class="bg-dark text-white p-3 rounded">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-2">
                            <div class="dropdown w-100">
                                <button class="form-select text-start bg-dark text-white border-secondary"
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    -- Genres --
                                </button>
                                <div class="dropdown-menu p-3 bg-dark text-white border-secondary w-100"
                                    style="max-height: 300px; overflow-y: auto;">
                                    @foreach ($genres as $genre)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="genre[]" value="{{ $genre->slug }}"
                                            id="genre-{{ $genre->id }}"
                                            {{ collect(request('genre'))->contains($genre->slug) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="genre-{{ $genre->id }}">
                                            {{ $genre->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <select name="release_year" class="form-select bg-dark text-white border-secondary">
                                <option value="">-- All years --</option>
                                @foreach ($releaseYears as $year)
                                <option value="{{ $year }}" {{ request('release_year') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="sort" class="form-select bg-dark text-white border-secondary">
                                <option value="">-- Sort by --</option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success w-50">Filter</button>
                        </div>
                    </div>
                </div>
            </form>

            @if ($movies->count())
            @foreach ($movies as $movie)
            <div class="col-9 col-md-3 col-lg-3 column-gap-1 rounded mb-3">
                <div class="text-center position-relative overflow-hidden rounded" style="height: 100%; aspect-ratio: 2/3;">
                    <img
                        src="{{ $movie->thumbnail ? asset('assets/images/thumbnails/'.$movie->thumbnail) : asset('assets/images/defaults/default-thumb.jpg') }}"
                        class="rounded w-100 h-100"
                        style="object-fit: cover; object-position: center;">
                    <div
                        class="position-absolute top-0 start-0 w-100 h-100 rounded"
                        style="background-image: linear-gradient(to bottom, rgb(0 0 0 /10%), rgb(0,0,0)); display: flex; align-items: flex-end;">
                        <div class="w-100 text-center pb-3 ps-1 pe-1">
                            <h2 class="text-white">{{ $movie->title }}</h2>
                            <a href="{{ route("movie.detail", $movie->slug)}}" class="btn btn-success rounded-pill mb-1 ps-3 pe-3">
                                Watch now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            {{ $movies->links() }}
            @else
            <div class="text-center py-5">
                <h4 class="text-white">No matching movies found.</h4>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection

@section('styles')
<style>
    .pagination .page-link {
        color: white;
        background-color: #212529;
        border-color: #212529;
        transition: background-color 0.3s ease;
    }

    .pagination .page-item.active .page-link {
        background-color: #343a40;
        border-color: #343a40;
        color: white;
    }

    .pagination .page-link:hover {
        background-color: #495057;
        border-color: #495057;
        color: white;
    }

    .pagination .page-item.active .page-link:hover {
        background-color: #6c757d;
        border-color: #6c757d;
    }
</style>
@endsection