@extends('admin.layout.main')
@section('title', 'Active Users')

@section('content')
<div class="container-fluid pt-2" x-data="{ showDeleteModal: false, confirmDelete: {} }">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-1">Active Users</h1>
            <p class="text-app-muted text-sm">Total: <span class="text-app-accent font-bold">{{ $users->total() }}</span> Active Users</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2.5 bg-app-bg text-app-muted hover:text-white hover:bg-app-cardHover rounded-lg transition-colors flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> All Users
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

    <div class="bg-app-card border border-app-border rounded-xl overflow-hidden shadow-lg">
        <!-- Top Bar: Show Entries + Search -->
        <div class="flex items-center justify-between gap-4 p-4 border-b border-app-border bg-app-bg">
            <div class="flex items-center gap-2">
                <label class="text-sm text-app-muted">Show</label>
                <form method="GET" action="{{ route('admin.users.active') }}" class="inline-flex items-center gap-2">
                    <!-- Preserve other query params -->
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                    <input type="hidden" name="order" value="{{ request('order') }}">
                    <input type="hidden" name="search" value="{{ request('search') }}">

                    <select name="per_page" onchange="this.form.submit()" class="px-3 py-1 rounded bg-app-card border border-app-border text-sm text-white cursor-pointer">
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </form>
                <span class="text-sm text-app-muted">entries</span>
            </div>

            <!-- Search -->
            <form method="GET" action="{{ route('admin.users.active') }}" class="flex items-center gap-2">
                <!-- Preserve other query params -->
                <input type="hidden" name="sort" value="{{ request('sort') }}">
                <input type="hidden" name="order" value="{{ request('order') }}">
                <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">

                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="px-3 py-1 rounded bg-app-card border border-app-border text-sm text-white placeholder-app-muted">
                <button type="submit" class="px-3 py-1 rounded bg-app-accent text-white text-sm hover:bg-app-accent/90">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-app-bg border-b border-app-border">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-app-muted uppercase tracking-wider cursor-pointer hover:text-white">
                            <a href="{{ route('admin.users.active', ['sort' => 'id', 'order' => request('sort') === 'id' && request('order') === 'asc' ? 'desc' : 'asc', 'per_page' => request('per_page'), 'search' => request('search')]) }}" class="flex items-center gap-2">
                                ID
                                @if(request('sort') === 'id')
                                    <i class="fas fa-{{ request('order') === 'desc' ? 'arrow-down' : 'arrow-up' }} text-xs text-app-accent"></i>
                                @else
                                    <i class="fas fa-arrow-up text-xs opacity-50"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-app-muted uppercase tracking-wider cursor-pointer hover:text-white">
                            <a href="{{ route('admin.users.active', ['sort' => 'nama', 'order' => request('sort') === 'nama' && request('order') === 'asc' ? 'desc' : 'asc', 'per_page' => request('per_page'), 'search' => request('search')]) }}" class="flex items-center gap-2">
                                Name
                                @if(request('sort') === 'nama')
                                    <i class="fas fa-{{ request('order') === 'desc' ? 'arrow-down' : 'arrow-up' }} text-xs text-app-accent"></i>
                                @else
                                    <i class="fas fa-arrow-up text-xs opacity-50"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-app-muted uppercase tracking-wider cursor-pointer hover:text-white">
                            <a href="{{ route('admin.users.active', ['sort' => 'email', 'order' => request('sort') === 'email' && request('order') === 'asc' ? 'desc' : 'asc', 'per_page' => request('per_page'), 'search' => request('search')]) }}" class="flex items-center gap-2">
                                Email
                                @if(request('sort') === 'email')
                                    <i class="fas fa-{{ request('order') === 'desc' ? 'arrow-down' : 'arrow-up' }} text-xs text-app-accent"></i>
                                @else
                                    <i class="fas fa-arrow-up text-xs opacity-50"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-app-muted uppercase tracking-wider cursor-pointer hover:text-white">
                            <a href="{{ route('admin.users.active', ['sort' => 'role_id', 'order' => request('sort') === 'role_id' && request('order') === 'asc' ? 'desc' : 'asc', 'per_page' => request('per_page'), 'search' => request('search')]) }}" class="flex items-center gap-2">
                                Role
                                @if(request('sort') === 'role_id')
                                    <i class="fas fa-{{ request('order') === 'desc' ? 'arrow-down' : 'arrow-up' }} text-xs text-app-accent"></i>
                                @else
                                    <i class="fas fa-arrow-up text-xs opacity-50"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-app-muted uppercase tracking-wider cursor-pointer hover:text-white">
                            <a href="{{ route('admin.users.active', ['sort' => 'alamat', 'order' => request('sort') === 'alamat' && request('order') === 'asc' ? 'desc' : 'asc', 'per_page' => request('per_page'), 'search' => request('search')]) }}" class="flex items-center gap-2">
                                Address
                                @if(request('sort') === 'alamat')
                                    <i class="fas fa-{{ request('order') === 'desc' ? 'arrow-down' : 'arrow-up' }} text-xs text-app-accent"></i>
                                @else
                                    <i class="fas fa-arrow-up text-xs opacity-50"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-app-muted uppercase tracking-wider cursor-pointer hover:text-white">
                            <a href="{{ route('admin.users.active', ['sort' => 'is_active', 'order' => request('sort') === 'is_active' && request('order') === 'asc' ? 'desc' : 'asc', 'per_page' => request('per_page'), 'search' => request('search')]) }}" class="flex items-center gap-2">
                                Status
                                @if(request('sort') === 'is_active')
                                    <i class="fas fa-{{ request('order') === 'desc' ? 'arrow-down' : 'arrow-up' }} text-xs text-app-accent"></i>
                                @else
                                    <i class="fas fa-arrow-up text-xs opacity-50"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-app-muted uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-app-border">
                    @forelse ($users as $user)
                        <tr class="hover:bg-app-bg/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-app-muted">{{ $user->id }}</td>
                            <td class="px-6 py-4 text-sm text-white font-medium flex items-center gap-3">
                                @if ($user->image)
                                    <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->nama }}" class="w-8 h-8 object-cover rounded-full border border-app-border">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-app-bg border border-app-border flex items-center justify-center">
                                        <i class="fas fa-user text-app-accent text-xs"></i>
                                    </div>
                                @endif
                                {{ $user->nama }}
                            </td>
                            <td class="px-6 py-4 text-sm text-app-muted">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $user->role_id == 1 ? 'bg-red-500/20 text-red-400' : 'bg-green-500/20 text-green-400' }}">
                                    {{ $user->role_id == 1 ? 'Admin' : 'User' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-app-muted">{{ Str::limit($user->alamat, 30) }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $user->is_active ? 'bg-green-500/20 text-green-400' : 'bg-gray-500/20 text-gray-400' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex gap-2">
                                    <form action="{{ route('admin.users.deactivate', $user) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1.5 bg-yellow-500/20 hover:bg-yellow-500/30 text-yellow-400 rounded text-xs font-medium transition-all flex items-center gap-1">
                                            <i class="fas fa-times"></i> Deactivate
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.users.show', $user) }}" class="px-3 py-1.5 bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 rounded text-xs font-medium transition-all flex items-center gap-1">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <button
                                        type="button"
                                        onclick="event.stopPropagation();"
                                        @click='confirmDelete = { id: {{ $user->id }}, name: {!! json_encode($user->nama) !!} }; showDeleteModal = true'
                                        class="px-3 py-1.5 bg-red-500/20 hover:bg-red-500/30 text-red-400 rounded text-xs font-medium transition-all flex items-center gap-1">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-app-muted">
                                <i class="fas fa-inbox text-2xl mb-2 block opacity-50"></i>
                                <p>All users have been activated</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination Info & Navigation -->
    <div class="mt-6 flex items-center justify-between">
        <div class="text-sm text-app-muted">
            Showing <span class="text-white font-bold">{{ $users->firstItem() ?? 0 }}</span> to
            <span class="text-white font-bold">{{ $users->lastItem() ?? 0 }}</span> of
            <span class="text-white font-bold">{{ $users->total() }}</span> entries
        </div>

        @if($users->hasPages())
            <div class="flex gap-2">
                @if ($users->onFirstPage())
                    <button disabled class="px-4 py-2 rounded bg-app-bg text-app-muted cursor-not-allowed">
                        <i class="fas fa-chevron-left"></i> Previous
                    </button>
                @else
                    <a href="{{ $users->previousPageUrl() }}" class="px-4 py-2 rounded bg-app-accent text-white hover:bg-app-accent/90">
                        <i class="fas fa-chevron-left"></i> Previous
                    </a>
                @endif

                @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                    @if ($page == $users->currentPage())
                        <button disabled class="px-4 py-2 rounded bg-app-accent text-white font-bold">{{ $page }}</button>
                    @else
                        <a href="{{ $url }}" class="px-4 py-2 rounded bg-app-bg text-white hover:bg-app-cardHover">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}" class="px-4 py-2 rounded bg-app-accent text-white hover:bg-app-accent/90">
                        Next <i class="fas fa-chevron-right"></i>
                    </a>
                @else
                    <button disabled class="px-4 py-2 rounded bg-app-bg text-app-muted cursor-not-allowed">
                        Next <i class="fas fa-chevron-right"></i>
                    </button>
                @endif
            </div>
        @endif
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
