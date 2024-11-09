@extends('auth.layouts')

@section('content')
<div class="mt-5">
    <form action="{{ route('gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3 row">
            <label for="title" class="col-md-4 col-form-label text-md-end">Title</label>
            <div class="col-md-6">
                <input type="text" class="form-control" id="title" name="title" value="{{ $gallery->title }}">
            </div>
        </div>

        <div class="mb-3 row">
            <label for="description" class="col-md-4 col-form-label text-md-end">Description</label>
            <div class="col-md-6">
                <textarea class="form-control" id="description" rows="5" name="description">{{ $gallery->description }}</textarea>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="input-file" class="col-md-4 col-form-label text-md-end">File input</label>
            <div class="col-md-6">
                <input type="file" class="form-control" id="input-file" name="picture">
            </div>
        </div>

        <div class="mb-3 row">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </form>
</div>
@endsection
