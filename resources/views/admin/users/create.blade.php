@extends('admin.layout.main')
@section('title', 'Create User')

@section('content')
<div class="container-fluid pt-2">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-1">Create New User</h1>
            <p class="text-app-muted text-sm">Add a new admin or regular user to the system</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2.5 bg-app-bg text-app-muted hover:text-white hover:bg-app-cardHover rounded-lg transition-colors flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Column -->
        <div class="lg:col-span-2">
            <div class="bg-app-card border border-app-border rounded-xl p-6 shadow-lg">
                <h2 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                    <i class="fas fa-user-plus text-app-accent"></i> Create New User Form
                </h2>

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-lg">
                        <p class="text-red-400 font-medium mb-2">Validation Error</p>
                        <ul class="text-red-400/80 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div class="mb-5">
                        <label for="nama" class="block text-sm font-semibold text-white mb-2">Full Name</label>
                           <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                               class="w-full px-4 py-2.5 bg-app-bg border {{ $errors->has('nama') ? 'border-red-500' : 'border-app-border' }} rounded-lg text-white placeholder-app-muted focus:outline-none focus:ring-2 focus:ring-app-accent/50 transition-all" placeholder="Enter full name" required>
                        @error('nama')
                            <p class="text-red-500 text-sm mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-semibold text-white mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               class="w-full px-4 py-2.5 bg-app-bg border {{ $errors->has('email') ? 'border-red-500' : 'border-app-border' }} rounded-lg text-white placeholder-app-muted focus:outline-none focus:ring-2 focus:ring-app-accent/50 transition-all" placeholder="example@mail.com" required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-5">
                        <label for="password" class="block text-sm font-semibold text-white mb-2">Password</label>
                           <input type="password" id="password" name="password"
                               class="w-full px-4 py-2.5 bg-app-bg border {{ $errors->has('password') ? 'border-red-500' : 'border-app-border' }} rounded-lg text-white placeholder-app-muted focus:outline-none focus:ring-2 focus:ring-app-accent/50 transition-all" placeholder="Minimum 8 characters" required>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div class="mb-5">
                        <label for="password_confirmation" class="block text-sm font-semibold text-white mb-2">Confirm Password</label>
                           <input type="password" id="password_confirmation" name="password_confirmation"
                               class="w-full px-4 py-2.5 bg-app-bg border {{ $errors->has('password_confirmation') ? 'border-red-500' : 'border-app-border' }} rounded-lg text-white placeholder-app-muted focus:outline-none focus:ring-2 focus:ring-app-accent/50 transition-all" placeholder="Repeat password" required>
                        @error('password_confirmation')
                            <p class="text-red-500 text-sm mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div class="mb-5">
                        <label for="alamat" class="block text-sm font-semibold text-white mb-2">Address</label>
                        <textarea id="alamat" name="alamat" rows="3"
                                  class="w-full px-4 py-2.5 bg-app-bg border {{ $errors->has('alamat') ? 'border-red-500' : 'border-app-border' }} rounded-lg text-white placeholder-app-muted focus:outline-none focus:ring-2 focus:ring-app-accent/50 transition-all resize-none" placeholder="Full address (optional)">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="text-red-500 text-sm mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-white mb-3">Role</label>
                        <div class="flex gap-3">
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="role_id" value="1" {{ old('role_id') == 1 ? 'checked' : '' }} class="sr-only peer" required>
                                <div class="px-4 py-3 bg-app-bg border-2 {{ old('role_id') == 1 ? 'border-app-accent bg-app-accent/10' : 'border-app-border' }} rounded-lg text-center transition-all peer-checked:border-app-accent peer-checked:bg-app-accent/10 hover:border-app-accent/50 cursor-pointer">
                                    <i class="fas fa-shield-alt text-lg {{ old('role_id') == 1 ? 'text-app-accent' : 'text-app-muted' }} mb-1 block"></i>
                                    <p class="text-sm font-medium {{ old('role_id') == 1 ? 'text-app-accent' : 'text-white' }}">Admin</p>
                                </div>
                            </label>
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="role_id" value="2" {{ old('role_id') == 2 ? 'checked' : '' }} class="sr-only peer" required>
                                <div class="px-4 py-3 bg-app-bg border-2 {{ old('role_id') == 2 ? 'border-app-accent bg-app-accent/10' : 'border-app-border' }} rounded-lg text-center transition-all peer-checked:border-app-accent peer-checked:bg-app-accent/10 hover:border-app-accent/50 cursor-pointer">
                                    <i class="fas fa-user text-lg {{ old('role_id') == 2 ? 'text-app-accent' : 'text-app-muted' }} mb-1 block"></i>
                                    <p class="text-sm font-medium {{ old('role_id') == 2 ? 'text-app-accent' : 'text-white' }}">User</p>
                                </div>
                            </label>
                        </div>
                        @error('role_id')
                            <p class="text-red-500 text-sm mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Is Active -->
                    <div class="mb-6">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}
                                   class="w-4 h-4 rounded border-app-border bg-app-bg cursor-pointer accent-app-accent">
                            <span class="text-sm font-medium text-white">Activate user immediately</span>
                        </label>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 pt-4 border-t border-app-border">
                        <button type="submit" class="px-6 py-2.5 bg-app-accent hover:bg-app-accent/90 text-white rounded-lg font-medium transition-all flex items-center gap-2">
                            <i class="fas fa-save"></i> Create User
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="px-6 py-2.5 bg-app-bg hover:bg-app-cardHover text-app-muted hover:text-white rounded-lg font-medium transition-all flex items-center gap-2 border border-app-border">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-app-card border border-app-border rounded-xl p-6 shadow-lg sticky top-20">
                <h3 class="text-lg font-bold text-white mb-4">Form Guide</h3>

                <div class="space-y-4 text-sm text-app-muted">
                    <div>
                        <p class="text-xs text-app-muted uppercase tracking-wide mb-1 font-semibold">Full Name</p>
                        <p>Enter full user name</p>
                    </div>
                    <div>
                        <p class="text-xs text-app-muted uppercase tracking-wide mb-1 font-semibold">Email</p>
                        <p>Use a unique, valid email</p>
                    </div>
                    <div>
                        <p class="text-xs text-app-muted uppercase tracking-wide mb-1 font-semibold">Password</p>
                        <p>Minimum 8 characters</p>
                    </div>
                    <div>
                        <p class="text-xs text-app-muted uppercase tracking-wide mb-1 font-semibold">Role</p>
                        <p>Admin: Full access to the system. User: Limited access</p>
                    </div>
                    <div class="pt-3 border-t border-app-border">
                        <p class="text-xs text-app-muted uppercase tracking-wide mb-1 font-semibold">Note</p>
                        <p>Ensure all fields marked with (*) are filled correctly</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
