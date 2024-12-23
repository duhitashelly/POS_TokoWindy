@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Pengaturan Profil</h1>

    <!-- Card untuk Form Update Profil -->
    <div class="card shadow-lg" style="max-width: 500px; margin: auto;">
        <div class="card-body">
            <!-- Form Update Profil -->
            <form method="POST" action="{{ route('user-profile-information.update') }}">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="name">Nama</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ Auth::user()->name }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ Auth::user()->email }}" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <hr>

    <!-- Card untuk Form Hapus Akun -->
    <div class="card shadow-lg mt-4" style="max-width: 500px; margin: auto;">
        <div class="card-body">
            <h5 class="card-title text-center mb-4">Hapus Akun</h5>

            <!-- Form Hapus Akun -->
            <form method="POST" action="{{ route('current-user.destroy') }}">
                @csrf
                @method('DELETE')

                <div class="text-center">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus akun?')">
                        Hapus Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
