@extends('admin.layout.main')
@section('title', 'Detail User - ' . $user->nama)

@section('content')
<div class="container-fluid pt-2" x-data="{ showDeleteModal: false, confirmDelete: {} }">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-1">Detail User</h1>
            <p class="text-app-muted text-sm">Complete Users Profile Information</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2.5 bg-app-bg text-app-muted hover:text-white hover:bg-app-cardHover rounded-lg transition-colors flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-500/10 border border-green-500/30 rounded-lg flex items-start gap-3">
            <i class="fas fa-check-circle text-green-400 mt-0.5"></i>
            <div>
                <p class="text-green-400 font-medium">Success</p>
                <p class="text-green-400/80 text-sm">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-app-card border border-app-border rounded-xl overflow-hidden shadow-lg">
                <div class="bg-gradient-to-r from-app-accent to-app-accent/70 h-24"></div>
                <div class="px-6 py-6 text-center -mt-12 relative z-10">
                    @if ($user->image)
                        <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->nama }}" class="w-24 h-24 mx-auto rounded-full object-cover border-4 border-app-card mb-4">
                    @else
                        <div class="w-24 h-24 mx-auto rounded-full bg-app-bg border-4 border-app-card flex items-center justify-center mb-4">
                            <i class="fas fa-user text-app-accent text-5xl"></i>
                        </div>
                    @endif
                    <h3 class="text-xl font-bold text-white mb-1">{{ $user->nama }}</h3>
                    <p class="text-app-muted text-sm mb-4">{{ $user->email }}</p>
                    <div class="flex gap-2 justify-center">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $user->role_id == 1 ? 'bg-red-500/20 text-red-400' : 'bg-green-500/20 text-green-400' }}">
                            {{ $user->role_id == 1 ? 'Admin' : 'User' }}
                        </span>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $user->is_active ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-gray-400' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details Card -->
        <div class="lg:col-span-2">
            <div class="bg-app-card border border-app-border rounded-xl p-6 shadow-lg">
                <h2 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                    <i class="fas fa-info-circle text-app-accent"></i> Detail Information
                </h2>

                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-app-muted uppercase tracking-wide mb-1">Full Name</p>
                            <p class="text-white font-medium">{{ $user->nama }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-app-muted uppercase tracking-wide mb-1">Email</p>
                            <p class="text-white font-medium">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
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
                    </div>

                    <div>
                        <p class="text-xs text-app-muted uppercase tracking-wide mb-1">Address</p>
                        <p class="text-white">{{ $user->alamat }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-app-muted uppercase tracking-wide mb-1">Created</p>
                            <p class="text-white font-medium">{{ $user->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-app-muted uppercase tracking-wide mb-1">Last Update</p>
                            <p class="text-white font-medium">{{ $user->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                            <div class="flex gap-3 mt-6 pt-6 border-t border-app-border">
                    <a href="{{ route('admin.users.edit', $user) }}" class="px-4 py-2.5 bg-app-accent hover:bg-app-accent/90 text-white rounded-lg font-medium transition-all flex items-center gap-2">
                        <i class="fas fa-edit"></i> Edit User
                    </a>
                            <div class="w-44">
                            <button type="button" onclick="event.stopPropagation();" @click='confirmDelete = { id: {{ $user->id }}, name: {!! json_encode($user->nama) !!} }; showDeleteModal = true' class="w-full inline-flex items-center justify-center gap-2 rounded-md border border-transparent bg-red-50 px-4 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2">
                                <i class="fas fa-trash"></i>
                                Delete User
                            </button>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete confirmation modal -->
    <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-black/60" @click="showDeleteModal = false"></div>
        <div class="relative bg-app-card border border-app-border rounded-lg p-6 w-full max-w-md mx-4">
            <h3 class="text-lg font-semibold text-white">Confirm To Delete User</h3>
            <p class="text-app-muted mt-2">You will delete the following user:</p>
            <p class="font-semibold text-white mt-3" x-text="confirmDelete.name"></p>
            <p class="text-sm text-app-muted mt-1">This action cannot be undone.</p>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" @click="showDeleteModal = false" class="px-4 py-2 rounded bg-app-bg/60 text-app-muted">Cancel</button>

                <form x-bind:action="'{{ url('admin/users') }}/' + (confirmDelete.id || '')" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 rounded bg-red-600 text-white">Delete User</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
