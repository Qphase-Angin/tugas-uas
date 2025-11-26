@extends('admin.layout.main')
@section('title', 'Edit User')
@section('content')

    <div class="container-fluid pt-4">
        <div class="max-w-3xl mx-auto">
            <div class="bg-app-card border border-app-border rounded-xl p-6">
                <h2 class="text-xl font-bold text-white mb-4">Edit User</h2>

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm text-app-muted mb-1">Nama</label>
                        <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" class="w-full p-2 rounded bg-app-bg border border-app-border text-white">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-app-muted mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full p-2 rounded bg-app-bg border border-app-border text-white">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-app-muted mb-1">Foto Profil (optional)</label>
                        <input type="file" name="image" class="w-full text-sm text-white">
                    </div>

                    <div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }} class="mr-2">
                            <span class="text-app-muted text-sm">Active</span>
                        </label>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="px-4 py-2 bg-app-accent text-white rounded">Simpan</button>
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-app-bg/60 text-app-muted rounded">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
