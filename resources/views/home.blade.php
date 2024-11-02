@extends('auth.layouts')

@section('title', 'Halaman Utama')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-12"> 
        <div class="card">
            <div class="card-header">Halaman Utama</div>
            <div class="card-body">
                <h2 class="text-center">Selamat Datang di Halaman Utama</h2>
                <p class="text-center">Ini adalah konten dari halaman utama.</p>
                
                <!-- Jika ingin menambahkan tabel atau konten tambahan -->
                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Id</th>
                            <th>Judul Buku</th>
                            <th>Penulis</th>
                            <th>Harga</th>
                            <th>Tanggal Terbit</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Contoh data statis untuk layout saja -->
                        <tr>
                            <td>1</td>
                            <td>101</td>
                            <td>Contoh Judul Buku</td>
                            <td>Penulis Contoh</td>
                            <td>Rp 50.000,00</td>
                            <td>01-01-2023</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <button type="button" class="btn btn-warning mr-2">Edit</button>
                                    <button type="button" class="btn btn-danger">Hapus</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Tambahkan tombol untuk navigasi atau aksi lain -->
                <a href="{{ route('buku.create') }}" class="btn btn-primary mt-3">Tambah Buku</a>
            </div>
        </div>
    </div>
</div>
@endsection
