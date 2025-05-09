@extends("layouts.app")

@section("title", $movie->title)

@section("content")
<section class="container py-5">
    <div class="row">
        <h1 class="mb-3 text-white">{{ $movie->title }}</h1>
        <div class="col-12 col-xl-5 mt-3">
            <div class="row">
                <div class="col-12 col-sm-5 col-md-4 col-lg-3 col-xl-5">
                    <img src="{{$movie->thumbnail }}" style="max-width: 350px;" width="100%" height="auto">
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
            <media-player title="{{ $movie->title }}" src="https://files.vidstack.io/sprite-fight/hls/stream.m3u8">
                <media-provider></media-provider>
                <media-video-layout></media-video-layout>
            </media-player>
        </div>
    </div>

    <div class="mt-4 text-center text-white">
        <h3 class="mb-3">Episode list</h3>
        <ul class="list-group">
            @forelse($movie->episodes as $episode)
            <li class="list-group-item bg-dark text-white">
                <a href="{{ route('movie.detail', ['slug' => $movie->slug]) }}?episode={{ $episode->id }}" class="text-info {{ $selectedEpisode && $selectedEpisode->id == $episode->id ? 'active' : '' }}">
                    Ep {{ $episode->episode_number }}
                </a>
            </li>
            @empty
            <li class="list-group-item bg-dark text-white">No episode yet</li>
            @endforelse
        </ul>
    </div>
</section>
@endsection

@section("styles")
<link rel="stylesheet" href="https://cdn.vidstack.io/player/theme.css" />
<link rel="stylesheet" href="https://cdn.vidstack.io/player/video.css" />
@endsection

@section("scripts")
<script src="https://cdn.vidstack.io/player" type="module"></script>
@endsection