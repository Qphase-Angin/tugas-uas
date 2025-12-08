@extends('admin.layout.main')
@section('title', 'Edit User - ' . $user->nama)

@section('content')
<div class="container-fluid pt-2">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-1">Edit User</h1>
            <p class="text-app-muted text-sm">{{ $user->nama }}</p>
        </div>
        <a href="{{ route('admin.users.show', $user) }}" class="px-4 py-2.5 bg-app-bg text-app-muted hover:text-white hover:bg-app-cardHover rounded-lg transition-colors flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Column -->
        <div class="lg:col-span-2">
            <div class="bg-app-card border border-app-border rounded-xl p-6 shadow-lg">
                <h2 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                    <i class="fas fa-edit text-app-accent"></i> Users Edit Form
                </h2>

                <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Nama Lengkap -->
                    <div class="mb-5">
                        <label for="nama" class="block text-sm font-semibold text-white mb-2">Full Name</label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama', $user->nama) }}"
                               class="w-full px-4 py-2.5 bg-app-bg border {{ $errors->has('nama') ? 'border-red-500' : 'border-app-border' }} rounded-lg text-white placeholder-app-muted focus:outline-none focus:ring-2 focus:ring-app-accent/50 transition-all" required>
                        @error('nama')
                            <p class="text-red-500 text-sm mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-semibold text-white mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                               class="w-full px-4 py-2.5 bg-app-bg border {{ $errors->has('email') ? 'border-red-500' : 'border-app-border' }} rounded-lg text-white placeholder-app-muted focus:outline-none focus:ring-2 focus:ring-app-accent/50 transition-all" required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div class="mb-5">
                        <label for="alamat" class="block text-sm font-semibold text-white mb-2">Address</label>
                        <textarea id="alamat" name="alamat" rows="3"
                                  class="w-full px-4 py-2.5 bg-app-bg border {{ $errors->has('alamat') ? 'border-red-500' : 'border-app-border' }} rounded-lg text-white placeholder-app-muted focus:outline-none focus:ring-2 focus:ring-app-accent/50 transition-all resize-none">{{ old('alamat', $user->alamat) }}</textarea>
                        @error('alamat')
                            <p class="text-red-500 text-sm mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-white mb-3">Role</label>
                        <div class="flex gap-3">
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="role_id" value="1" {{ old('role_id', $user->role_id) == 1 ? 'checked' : '' }} class="sr-only peer" required>
                                <div class="px-4 py-3 bg-app-bg border-2 {{ old('role_id', $user->role_id) == 1 ? 'border-app-accent bg-app-accent/10' : 'border-app-border' }} rounded-lg text-center transition-all peer-checked:border-app-accent peer-checked:bg-app-accent/10 hover:border-app-accent/50 cursor-pointer">
                                    <i class="fas fa-shield-alt text-lg {{ old('role_id', $user->role_id) == 1 ? 'text-app-accent' : 'text-app-muted' }} mb-1 block"></i>
                                    <p class="text-sm font-medium {{ old('role_id', $user->role_id) == 1 ? 'text-app-accent' : 'text-white' }}">Admin</p>
                                </div>
                            </label>
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="role_id" value="2" {{ old('role_id', $user->role_id) == 2 ? 'checked' : '' }} class="sr-only peer" required>
                                <div class="px-4 py-3 bg-app-bg border-2 {{ old('role_id', $user->role_id) == 2 ? 'border-app-accent bg-app-accent/10' : 'border-app-border' }} rounded-lg text-center transition-all peer-checked:border-app-accent peer-checked:bg-app-accent/10 hover:border-app-accent/50 cursor-pointer">
                                    <i class="fas fa-user text-lg {{ old('role_id', $user->role_id) == 2 ? 'text-app-accent' : 'text-app-muted' }} mb-1 block"></i>
                                    <p class="text-sm font-medium {{ old('role_id', $user->role_id) == 2 ? 'text-app-accent' : 'text-white' }}">User</p>
                                </div>
                            </label>
                        </div>
                        @error('role_id')
                            <p class="text-red-500 text-sm mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 pt-4 border-t border-app-border">
                        <button type="submit" class="px-6 py-2.5 bg-app-accent hover:bg-app-accent/90 text-white rounded-lg font-medium transition-all flex items-center gap-2">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                        <a href="{{ route('admin.users.show', $user) }}" class="px-6 py-2.5 bg-app-bg hover:bg-app-cardHover text-app-muted hover:text-white rounded-lg font-medium transition-all flex items-center gap-2 border border-app-border">
                            <i class="fas fa-times"></i> Decline
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-app-card border border-app-border rounded-xl p-6 shadow-lg sticky top-20">
                <h3 class="text-lg font-bold text-white mb-4">Info User</h3>

                <div class="text-center mb-4">
                    @if ($user->image)
                        <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->nama }}"
                             class="w-24 h-24 mx-auto rounded-full object-cover border-2 border-app-accent mb-3">
                    @else
                        <div class="w-24 h-24 mx-auto rounded-full bg-app-bg border-2 border-app-border flex items-center justify-center mb-3">
                            <i class="fas fa-user text-app-accent text-4xl"></i>
                        </div>
                    @endif
                    <h4 class="font-bold text-white mb-0.5">{{ $user->nama }}</h4>
                    <p class="text-xs text-app-muted">{{ $user->email }}</p>
                </div>

                <div class="space-y-3 border-t border-app-border pt-4">
                    <div>
                        <p class="text-xs text-app-muted uppercase tracking-wide mb-1">Role</p>
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $user->role_id == 1 ? 'bg-red-500/20 text-red-400' : 'bg-green-500/20 text-green-400' }}">
                            {{ $user->role_id == 1 ? 'Admin' : 'User' }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-app-muted uppercase tracking-wide mb-1">Status</p>
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $user->is_active ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-gray-400' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-app-muted uppercase tracking-wide mb-1">Create</p>
                        <p class="text-sm text-white">{{ $user->created_at->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-app-muted uppercase tracking-wide mb-1">Last Update</p>
                        <p class="text-sm text-white">{{ $user->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
