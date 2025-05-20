@extends("admin.layouts.admin-app")

@section("title", "Edit Episode ".$episode->title)

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
<form action="{{ route("movie.update", $movie->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method("PUT")
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label for="">Title</label>
                <input type="text" name="title" value="{{ $movie->title }}" class="form-control" placeholder="Enter title">
            </div>
            <div class="form-group" style="height: 200px;">
                <label for="">Description</label>
                <textarea name="description" class="form-control" placeholder="Description" style="height: 100%;">{{ $movie->description }}</textarea>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Genres</label>
                <div class="d-flex flex-wrap">
                    @foreach ($genres as $genre)
                    <div class="form-check me-3 mb-2">
                        <input
                            type="checkbox"
                            name="genres[]"
                            value="{{ $genre->id }}"
                            class="form-check-input"
                            id="genre{{ $genre->id }}"
                            {{ $movie->genres->contains($genre->id) ? 'checked' : '' }}>
                        <label class="form-check-label" for="genre{{ $genre->id }}">
                            {{ $genre->name }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="form-group">
                <label for="">Release year</label>
                <select name="release_year" id="release_year" class="form-control @error('release_year') is-invalid @enderror">
                    <option value="">-- Choose year --</option>
                    @for ($year = date('Y'); $year >= 1950; $year--)
                    <option value="{{ $year }}" {{ $movie->release_year == $year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                    @endfor
                </select>
            </div>
            <div class="form-group row">
                <label for="" class="col-md-2">Status</label>
                <div class="radio col-md-5">
                    <label for=""><input type="radio" name="status" value="1" {{ $movie->status == 1 ? 'checked' : '' }}> Publish</label>
                </div>
                <div class="radio col-md-5">
                    <label for=""><input type="radio" name="status" value="0" {{ $movie->status == 0 ? 'checked' : '' }}> Hidden</label>
                </div>
            </div>
            <div class="form-group">
                <label for="">Thumbnail</label>
                <input type="file" name="thumbnail" class="form-control">
                <br>
                <img src="{{ asset('assets/images/thumbnails/'.$movie->thumbnail) }}" alt="" width="100%">
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