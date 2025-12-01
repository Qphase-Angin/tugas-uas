@extends('admin.layout.main')
@section('title', 'Item Detail')
@section('content')

    <div class="container-fluid pt-4" x-data="{ showDeleteModal: false, confirmDelete: {} }" @delete-item.window="confirmDelete = $event.detail; showDeleteModal = true">
        <a href="{{ route('admin.items.index') }}" class="text-sm text-app-muted hover:underline">← Back to items</a>

        <div class="mt-4 bg-app-card border border-app-border rounded-xl p-6">
            <div class="flex gap-6 items-start">
                <div class="w-48 h-48 bg-app-bg/30 rounded overflow-hidden flex items-center justify-center border border-app-border">
                    @if(!empty($item->image))
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                    @else
                        <i class="fas fa-box-open text-white text-4xl"></i>
                    @endif
                </div>

                <div class="flex-1">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-white">{{ $item->name }}</h2>
                            <p class="text-app-muted text-sm mt-1">{{ $item->category->name ?? '-' }} · {{ ucfirst(data_get($item, 'metadata.rarity', 'common')) }}</p>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.items.edit', $item->id) }}" class="px-3 py-2 rounded bg-app-accent text-white hover:bg-app-accent/90">Edit</a>

                            <button
                                type="button"
                                @click='confirmDelete = { id: {{ $item->id }}, name: {!! json_encode($item->name) !!} }; showDeleteModal = true'
                                class="px-3 py-2 rounded bg-red-600/80 hover:bg-red-600 text-white">Hapus</button>
                                <!-- Delete confirmation modal (reused from dashboard) -->
                                <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
                                    <div class="absolute inset-0 bg-black/60" @click="showDeleteModal = false"></div>
                                    <div class="relative bg-app-card border border-app-border rounded-lg p-6 w-full max-w-md mx-4">
                                        <h3 class="text-lg font-semibold text-white">Konfirmasi Hapus Item</h3>
                                        <p class="text-app-muted mt-2">Anda akan menghapus item berikut:</p>
                                        <p class="font-semibold text-white mt-3" x-text="confirmDelete.name"></p>
                                        <p class="text-sm text-app-muted mt-1">Tindakan ini tidak dapat dibatalkan. Gambar item akan dihapus juga.</p>

                                        <div class="mt-6 flex justify-end gap-3">
                                            <button type="button" @click="showDeleteModal = false" class="px-4 py-2 rounded bg-app-bg/60 text-app-muted">Batal</button>

                                            <form x-show="confirmDelete.id" x-bind:action="'{{ url('admin/items') }}/' + confirmDelete.id" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-4 py-2 rounded bg-red-600 text-white" :disabled="!confirmDelete.id">Hapus Item</button>
                                            </form>
                                            <div x-show="!confirmDelete.id" class="mt-4 text-sm text-red-400">Tidak ada item yang dipilih.</div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="col-span-2">
                            <h3 class="text-sm text-app-muted mb-2">Deskripsi</h3>
                            <div class="bg-app-bg/30 border border-app-border rounded p-4 text-app-muted">{{ $item->description }}</div>
                        </div>

                        <div class="space-y-3">
                            <div class="bg-app-bg/30 border border-app-border rounded p-4">
                                <div class="text-sm text-app-muted">Harga</div>
                                <div class="font-semibold text-white mt-1">Rp {{ number_format($item->price, 2, ',', '.') }}</div>
                            </div>

                            <div class="bg-app-bg/30 border border-app-border rounded p-4">
                                <div class="text-sm text-app-muted">Rarity</div>
                                <div class="font-semibold text-white mt-1">{{ ucfirst(data_get($item, 'metadata.rarity', 'common')) }}</div>
                            </div>

                            <div class="bg-app-bg/30 border border-app-border rounded p-4">
                                <div class="text-sm text-app-muted">Kategori</div>
                                <div class="font-semibold text-white mt-1">{{ $item->category->name ?? '—' }}</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection
