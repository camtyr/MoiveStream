@extends("admin.layouts.admin-app")

@section("title", "Genre Management")

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
    <a href="{{ route("genre.create") }}" class="btn btn-success ml-auto"><i class="fa fa-plus">Add new</i></a>
</form>

<br>

<div class="table-responsive">
    <table class="table table-hover table-dark">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Slug</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($genres as $genre)
            <tr class="align-middle">
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $genre->name }}</td>
                <td>{{ $genre->slug }}</td>
                <td class="text-right" style="white-space: nowrap;">
                    <form action="{{ route("genre.destroy",$genre->id) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this genre?')">
                        @csrf @method("DELETE")

                        <a href="{{ route("genre.edit",$genre->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-solid fa-pen"></i></a>
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-solid fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $genres->links() }}
</div>
@endsection