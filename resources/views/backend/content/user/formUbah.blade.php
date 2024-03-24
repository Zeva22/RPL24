@extends('backend/layout/main')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Form Ubah User</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('user.prosesUbah') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama User</label>
                    <input type="text" id="name" name="name" value="{{ $user->name }}" class="form-control @error('name') is-invalid @enderror">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email User</label>
                    <input type="email" id="email" name="email" value="{{ $user->email }}" class="form-control @error('email') is-invalid @enderror">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <input type="hidden" name="id" value="{{ $user->id }}">
                <button type="submit" class="btn btn-primary">Ubah</button>
                <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
