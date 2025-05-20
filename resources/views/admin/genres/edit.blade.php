@extends("admin.layouts.admin-app")

@section("title", "Edit Genre")

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
<form action="{{ route("genre.update", $genre->id) }}" method="post">
    @csrf
    @method("PUT")
    <div class="form-group" style="width: 300px;">
        <label for="">Name</label>
        <input type="text" name="name" value="{{ $genre->name }}" class="form-control" placeholder="Enter name">
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