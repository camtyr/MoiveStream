@extends("admin.layouts.admin-app")

@section("title", "Create New Movie")

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
<form action="{{ route("movie.store") }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-7">
            <div class="form-group">
                <label for="">Title</label>
                <input type="text" name="title" class="form-control" placeholder="Enter title">
            </div>
            <div class="form-group">
                <label for="">Description</label>
                <textarea name="description" class="form-control" placeholder="Description" style="height: 200px;"></textarea>
            </div>
        </div>
        <div class="col-md-5">
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
                            id="genre{{ $genre->id }}">
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
                    <option value="{{ $year }}" {{ old('release_year') == $year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                    @endfor
                </select>
            </div>
            <div class="form-group row">
                <label for="" class="col-md-2">Status</label>
                <div class="radio col-md-5">
                    <label for=""><input type="radio" name="status" value="1" checked> Publish</label>
                </div>
                <div class="radio col-md-5">
                    <label for=""><input type="radio" name="status" value="0"> Hidden</label>
                </div>
            </div>
            <div class="form-group">
                <label for="">Thumbnail</label>
                <input type="file" name="thumbnail" class="form-control">
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