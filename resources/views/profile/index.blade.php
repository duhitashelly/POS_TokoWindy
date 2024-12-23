@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Profil Saya</h1>
    
    <div class="card shadow-lg" style="max-width: 500px; margin: auto;">
        <div class="card-body text-center">
            <!-- Foto Profil -->
            <div class="mb-3">
                @if(Auth::user()->profile_photo_path)
                    <!-- Menampilkan foto profil pengguna jika ada -->
                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" class="rounded-circle" width="150" height="150" alt="Foto Profil">
                @else
                    <!-- Menampilkan foto default jika tidak ada foto profil -->
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" class="rounded-circle" width="150" height="150" alt="Foto Profil Default">
                @endif
            </div>
            
            <!-- Nama dan Email -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Nama:</strong>
                </div>
                <div class="col-md-8">
                    {{ Auth::user()->name }}
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <strong>Email:</strong>
                </div>
                <div class="col-md-8">
                    {{ Auth::user()->email }}
                </div>
            </div>
        </div>
    </div>

    <!-- Tautan ke halaman pengaturan profil -->
    <div class="text-center mt-4">
        <a href="{{ route('profile.show') }}" class="btn btn-primary">Edit Profil</a>
    </div>
</div>
@endsection
