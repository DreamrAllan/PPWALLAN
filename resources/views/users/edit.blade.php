@extends('auth.layouts')

@section('content')
    <h2>Edit User</h2>
    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div>
            <label>Name</label>
            <input type="text" name="name" value="{{ $user->name }}" required>
        </div>
        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ $user->email }}" required>
        </div>
        <div>
            <label>Photo</label>
            <input type="file" name="photo">
            @if ($user->photo)
                <img src="{{ asset('storage/' . $user->photo) }}" width="100px">
            @endif
        </div>
        <button type="submit">Update User</button>
    </form>
@endsection
