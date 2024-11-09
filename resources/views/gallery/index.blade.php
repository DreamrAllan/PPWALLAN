@extends('auth.layouts')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <span>Dashboard</span>
                <a href="{{ route('gallery.create') }}" class="btn btn-primary float-end">Tambah Gambar</a>
            </div>
            <div class="card-body">
                <div class="row">
                    @if(count($galleries) > 0)
                        @foreach($galleries as $gallery)
                        <div class="col-sm-2">
                    <div>
                        <a class="example-image-link" 
                        href="{{ asset('storage/posts_image/' . $gallery->picture) }}" 
                        data-lightbox="roadtrip" 
                        data-title="{{ $gallery->description }}">
                            <img class="example-image img-fluid mb-2" 
                                src="{{ asset('storage/posts_image/' . $gallery->picture) }}" 
                                alt="image" />
                        </a>
                        <a href="{{ route('gallery.edit', $gallery->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('gallery.destroy', $gallery->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </div>
                        @endforeach
                    @else
                        <h3>Tidak ada data.</h3>
                    @endif
                    <div class="d-flex">
                        {{ $galleries->links() }}
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</div>
@endsection