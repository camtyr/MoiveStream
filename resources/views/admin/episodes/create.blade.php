@extends("admin.layouts.admin-app")

@section("title", "Create New Episode")

@section("content")
@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form action="{{ route("episode.store") }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-7">
            <div class="form-group">
                <label for="">Movie</label>
                <select name="movie_id" class="form-control">
                    @foreach ($movies as $movie)
                    <option value="{{ $movie->id }}">{{ $movie->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="">Title</label>
                <input type="text" name="title" class="form-control" placeholder="Enter title">
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label for="episode_number">Episode Number</label>
                <input type="number" name="episode_number" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="video">Upload MP4 Video</label>
                <input type="file" name="video" class="form-control" accept="video/mp4" required>
            </div>
        </div>
    </div>


    <button type="submit" class="btn btn-secondary"><i class="fas fa-solid fa-save"> Save</i></button>
</form>
@endsection

@section("styles")
<style>
    ::placeholder {
        opacity: 0.2;
        color: gray !important;
    }
</style>
@endsection