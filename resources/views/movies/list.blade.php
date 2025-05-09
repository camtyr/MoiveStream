@extends('layouts.app')

@section('title', 'List Movies')

@section('content')
<section>
    <div class="container" style="max-width: 1200px">
        <div class="row pt-5 d-flex justify-content-center">
            @foreach ($movies as $movie)
            <div class="col-9 col-md-3 col-lg-3 column-gap-1 rounded mb-3">
                <div class="text-center position-relative overflow-hidden rounded" style="height: 100%; aspect-ratio: 2/3;">
                    <img
                        src="{{ $movie->thumbnail }}"
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