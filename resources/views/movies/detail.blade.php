@extends("layouts.app")

@section("title", $movie->title)

@section("content")
<section class="container py-5">
    <div class="row">
        <h1 class="mb-3 text-white">{{ $movie->title }}</h1>
        <div class="col-12 col-xl-5 mt-3">
            <div class="row">
                <div class="col-12 col-sm-5 col-md-4 col-lg-3 col-xl-5">
                    <img src="{{ asset('assets/images/thumbnails/'.$movie->thumbnail)}}" style="max-width: 350px;" width="100%" height="auto">
                </div>

                <div class="col-12 col-md-8 col-lg-9 col-xl-7">
                    <div class="mt-3">
                        <div class="card bg-dark p-3 text-white">
                            {{ $movie->description }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-7 mt-3 text-white">
            @if($selectedEpisode)
            <media-player
                title="{{ $movie->title }} - Ep {{ $selectedEpisode->episode_number }}"
                src="{{route("movie.playlist", [$movie->slug, $selectedEpisode->episode_number, "index.m3u8"]) }}">

                <media-provider></media-provider>
                <media-video-layout></media-video-layout>
            </media-player>
            @else
            <div class="alert alert-danger">
                <strong>Something went wrong!</strong> No episode available for this movie.
            </div>
            @endif
        </div>
    </div>

    <div class="mt-4 text-center text-white">
        <h3 class="mb-3">Episode list</h3>

        <div class="border border-info rounded p-4 bg-dark">
            <div class="d-flex flex-wrap justify-content-center gap-2">
                @forelse($movie->episodes as $episode)
                <a href="{{ route('movie.detail', ['slug' => $movie->slug]) }}?episode={{ $episode->id }}"
                    class="btn episode-btn {{ $selectedEpisode && $selectedEpisode->id == $episode->id ? 'active' : '' }}">
                    Ep {{ $episode->episode_number }}
                </a>
                @empty
                <p class="text-white">No episode yet</p>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection

@section("styles")
<link rel="stylesheet" href="https://cdn.vidstack.io/player/theme.css" />
<link rel="stylesheet" href="https://cdn.vidstack.io/player/video.css" />

<style>
    .episode-btn {
        background-color: #343a40;
        color: #17a2b8;
        border: 1px solid #17a2b8;
        transition: all 0.3s ease;
    }

    .episode-btn:hover {
        background-color: #17a2b8;
        color: white;
        text-decoration: none;
    }

    .episode-btn.active {
        background-color: #17a2b8;
        color: white;
        pointer-events: none;
        font-weight: bold;
    }
</style>
@endsection

@section("scripts")
<script src="https://cdn.vidstack.io/player" type="module"></script>
@endsection