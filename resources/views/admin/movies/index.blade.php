@extends("admin.layouts.admin-app")

@section("title", "Movie Management")

@section("content")
<form class="d-flex form-inline">
    <div class="form-group mr-1">
        <label for="" class="sr-only">label</label>
        <input
            type="text"
            name=""
            id=""
            class="form-control"
            placeholder=""
            aria-describedby="helpId" />
    </div>

    <button type="submit" class="btn btn-secondary mr-1"><i class="fa fa-search"></i></button>
    <a href="{{ route("movie.create") }}" class="btn btn-success ml-auto"><i class="fa fa-plus">Add new</i></a>
</form>

<br>

<div class="table-responsive">
    <table class="table table-hover table-dark">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Slug</th>
                <th>Thumbnail</th>
                <th>Genres</th>
                <th>Release year</th>
                <th>Description</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movies as $movie)
            <tr class="align-middle">
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $movie->title }}</td>
                <td>{{ $movie->slug }}</td>
                <td><img src="{{ asset('assets/images/thumbnails/'.$movie->thumbnail)}}" alt="{{ $movie->title }}" width="100"></td>
                <td>
                    @foreach($movie->genres as $genre)
                    {{ $genre->name }}@if (!$loop->last), @endif
                    @endforeach
                </td>
                <td>{{ $movie->release_year }}</td>
                <td>{{ $movie->description }}</td>
                <td>{{ $movie->status }}</td>
                <td class="text-right" style="white-space: nowrap;">
                    <form action="{{ route("movie.destroy",$movie->id) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this movie?')">
                        @csrf 
                        @method("DELETE")

                        <a href="{{ route("movie.edit",$movie->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-solid fa-pen"></i></a>
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $movies->links() }}
</div>
@endsection