@extends('auth.layouts')

@section('content')
    <!-- Flash Message -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Tabel User -->
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Photo</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if ($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="User Photo" width="50">
                    @else
                        No photo
                    @endif
                </td>
                <td>
                    <button onclick="showEditForm('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}', '{{ asset('storage/' . $user->photo) }}')">Edit</button>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Formulir Edit (Muncul saat tombol Edit diklik) -->
<div id="editFormContainer" style="display:none; margin-top:20px;">
    <form id="editForm" action="" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="name">Name:</label>
        <input type="text" id="editName" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="editEmail" name="email" required>

        <label for="photo">Profile Image:</label>
        <input type="file" id="editPhoto" name="photo">
        <br>
        <button type="submit">Update</button>
    </form>
</div>

<script>
function showEditForm(userId, name, email, photoUrl) {
    // Isi data dalam form dengan data user
    document.getElementById('editForm').action = '/users/' + userId;
    document.getElementById('editName').value = name;
    document.getElementById('editEmail').value = email;

    // Tampilkan formulir edit
    document.getElementById('editFormContainer').style.display = 'block';
}
</script>


@endsection
