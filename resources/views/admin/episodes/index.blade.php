@extends("admin.layouts.admin-app")

@section("title", "Episode Management")

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
    <a href="{{ route("episode.create") }}" class="btn btn-success ml-auto"><i class="fa fa-plus">Add new</i></a>
</form>

<br>

<div class="table-responsive">
    <table class="table table-hover table-dark">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Episode number</th>
                <th>Movie title</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($episodes as $episode)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $episode->title }}</td>
                <td>{{ $episode->episode_number }}</td>
                <td>{{ $episode->movie->title }}</td>
                <td class="text-right">
                    <form action="{{ route("episode.destroy",$episode->id) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this episode?')">
                        @csrf @method("DELETE")

                        <a href="{{ route("episode.edit",$episode->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-solid fa-pen"></i></a>
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $episodes->links() }}
</div>
@endsection