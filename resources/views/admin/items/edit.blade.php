@extends('admin.layout.main')
@section('title', 'Edit Item / Skin')
@section('content')

    <div class="container-fluid pt-4">
        <div class="max-w-3xl mx-auto">
            <div class="bg-app-card border border-app-border rounded-xl p-6">
                <h2 class="text-xl font-bold text-white mb-4">Edit Item / Skin</h2>

                @if ($errors->any())
                    <div class="mb-4">
                        <div class="bg-red-700/80 border border-red-500 text-white rounded px-4 py-3">
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                <form action="{{ route('admin.items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm text-app-muted mb-1">Nama Item</label>
                        <input type="text" name="name" value="{{ old('name', $item->name) }}" required class="w-full p-2 rounded bg-app-bg border border-app-border text-white">
                        @error('name') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-app-muted mb-1">Deskripsi</label>
                        <textarea name="description" rows="4" maxlength="250" class="w-full p-2 rounded bg-app-bg border border-app-border text-white resize-none" style="resize: none;">{{ old('description', $item->description) }}</textarea>
                        <p class="text-xs text-app-muted mt-1">Maks 250 karakter.</p>
                        @error('description') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-app-muted mb-1">Harga (IDR)</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-3 text-app-muted text-lg pointer-events-none select-none">Rp</span>
                            <input type="text" name="price" inputmode="decimal" value="{{ old('price', isset($item->price) ? number_format($item->price, 2, ',', '.') : '0,01') }}" required class="w-full pl-10 p-2 rounded bg-app-bg border border-app-border text-white focus:ring-2 focus:ring-app-accent" placeholder="0.00" autocomplete="off">
                        </div>
                        <p class="text-xs text-app-muted mt-1">Gunakan format angka, contoh: <code>12500</code>, <code>12.500</code>, <code>12,500.50</code> atau <code>0,01</code></p>
                        @error('price') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-app-muted mb-1">Kategori</label>
                        <div class="mb-2">
                            <div id="category-selected-preview" class="inline-flex items-center gap-3 px-4 py-2 rounded-md bg-app-bg/60 border border-app-border text-sm text-white">
                                <span class="text-app-muted">Belum ada kategori dipilih</span>
                            </div>
                        </div>
                        <div class="flex gap-2 flex-wrap">
                            @php
                                $catIcons = [
                                    'Guns' => '<svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="7"/><path d="M12 5v7l3 3" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                                    'Knives' => '<svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 21c2-1 6-5 10-9s8-8 8-8l-4-1s-4 4-8 8S4 18 3 21z" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                                    'Gloves' => '<svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M7 11V6a2 2 0 114 0v6" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 6v6a3 3 0 01-3 3H8l-2 2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                                    'Stickers' => '<svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 7v10a2 2 0 002 2h10l6-6V7a2 2 0 00-2-2H5a2 2 0 00-2 2z" stroke-linecap="round" stroke-linejoin="round"/><circle cx="8.5" cy="10.5" r="1" fill="currentColor" stroke="none"/></svg>',
                                ];
                                $catGradients = [
                                    'Guns' => 'bg-gradient-to-r from-blue-700 via-blue-500 to-blue-400 text-white',
                                    'Knives' => 'bg-gradient-to-r from-gray-800 via-gray-600 to-gray-400 text-white',
                                    'Gloves' => 'bg-gradient-to-r from-yellow-600 via-yellow-400 to-yellow-200 text-black',
                                    'Stickers' => 'bg-gradient-to-r from-pink-600 via-pink-400 to-pink-200 text-white',
                                ];
                            @endphp
                            @foreach($categories ?? [] as $cat)
                                @php
                                    $localIcon = null;
                                    $svgPath = public_path('storage/categories/' . ($cat->slug ?? Str::slug($cat->name)) . '.svg');
                                    $pngPath = public_path('storage/categories/' . ($cat->slug ?? Str::slug($cat->name)) . '.png');
                                    if (file_exists($svgPath)) {
                                        $localIcon = asset('storage/categories/' . ($cat->slug ?? Str::slug($cat->name)) . '.svg');
                                    } elseif (file_exists($pngPath)) {
                                        $localIcon = asset('storage/categories/' . ($cat->slug ?? Str::slug($cat->name)) . '.png');
                                    }
                                @endphp

                                <label class="cursor-pointer" data-cat-name="{{ $cat->name }}">
                                    <input type="radio" name="category_id" value="{{ $cat->id }}" class="hidden" {{ old('category_id', $item->category_id) == $cat->id ? 'checked' : '' }}>
                                    <span class="inline-flex items-center gap-2 px-5 py-2 rounded-full {{ $catGradients[$cat->name] ?? 'bg-app-bg text-white' }} shadow-lg hover:scale-105 hover:shadow-xl transition-all border border-app-border {{ old('category_id', $item->category_id) == $cat->id ? 'ring-2 ring-app-accent' : '' }}" style="font-weight:600;" data-cat-name="{{ $cat->name }}">
                                        <span class="cat-icon-html hidden">{!! $catIcons[$cat->name] ?? '' !!}</span>
                                        @if($localIcon)
                                            <img src="{{ $localIcon }}" alt="{{ $cat->name }}" class="w-5 h-5 object-contain">
                                        @else
                                            {!! $catIcons[$cat->name] ?? '' !!}
                                        @endif
                                        <span class="cat-name">{{ $cat->name }}</span>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        @error('category_id') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-app-muted mb-1">Gambar Item (jpg/png)</label>
                        <div class="flex items-center gap-3">
                            <label for="item-image-input" class="inline-flex items-center gap-2 px-4 py-2 bg-app-accent text-white rounded cursor-pointer hover:opacity-90 transition-colors">
                                <i class="fas fa-upload"></i>
                                <span>Choose file</span>
                            </label>
                            <input id="item-image-input" type="file" name="image" accept="image/*,.webp,image/webp" class="hidden" onchange="document.getElementById('item-image-filename').textContent = this.files && this.files.length ? this.files[0].name : 'No file chosen'">
                            <span id="item-image-filename" class="text-sm text-app-muted">{{ $item->image ? basename($item->image) : 'No file chosen' }}</span>
                        </div>
                        @if($item->image)
                            <div class="mt-3">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="preview" class="w-32 h-32 object-cover rounded border border-app-border">
                            </div>
                        @endif
                        @error('image') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-app-muted mb-2">Rarity</label>
                        <input type="hidden" name="rarity" value="{{ old('rarity', data_get($item, 'metadata.rarity', 'common')) }}">
                        @php
                            $rarities = [
                                'common' => ['label' => 'Common', 'class' => 'bg-gray-600 text-white', 'color' => '#6b7280'],
                                'uncommon' => ['label' => 'Uncommon', 'class' => 'bg-green-600 text-white', 'color' => '#16a34a'],
                                'rare' => ['label' => 'Rare', 'class' => 'bg-blue-600 text-white', 'color' => '#2563eb'],
                                'mythical' => ['label' => 'Mythical', 'class' => 'bg-purple-600 text-white', 'color' => '#7c3aed'],
                                'legendary' => ['label' => 'Legendary', 'class' => 'bg-yellow-500 text-black', 'color' => '#f59e0b'],
                                'ancient' => ['label' => 'Ancient', 'class' => 'bg-indigo-800 text-white', 'color' => '#3730a3'],
                                'exceedingly_rare' => ['label' => 'Exceedingly Rare', 'class' => 'bg-pink-600 text-white', 'color' => '#db2777'],
                                'immortal' => ['label' => 'Immortal', 'class' => 'bg-red-600 text-white', 'color' => '#dc2626'],
                            ];
                            $selected = old('rarity', data_get($item, 'metadata.rarity', 'common'));
                        @endphp

                        <div role="radiogroup" aria-label="Rarity" class="flex flex-wrap gap-2 items-center">
                            @php
                                $rarityGradients = [
                                    'common' => 'bg-gradient-to-r from-gray-600 via-gray-400 to-gray-200 text-white',
                                    'uncommon' => 'bg-gradient-to-r from-green-600 via-green-400 to-green-200 text-white',
                                    'rare' => 'bg-gradient-to-r from-blue-600 via-blue-400 to-blue-200 text-white',
                                    'mythical' => 'bg-gradient-to-r from-purple-600 via-purple-400 to-purple-200 text-white',
                                    'legendary' => 'bg-gradient-to-r from-yellow-500 via-yellow-300 to-yellow-100 text-black',
                                    'ancient' => 'bg-gradient-to-r from-indigo-800 via-indigo-500 to-indigo-200 text-white',
                                    'exceedingly_rare' => 'bg-gradient-to-r from-pink-600 via-pink-400 to-pink-200 text-white',
                                    'immortal' => 'bg-gradient-to-r from-red-600 via-red-400 to-red-200 text-white',
                                ];
                            @endphp
                            @foreach($rarities as $key => $r)
                                <button
                                    type="button"
                                    role="radio"
                                    aria-checked="{{ $selected === $key ? 'true' : 'false' }}"
                                    tabindex="0"
                                    data-value="{{ $key }}"
                                    data-color="{{ $r['color'] }}"
                                    class="rarity-btn inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium transition-all focus:outline-none border"
                                    style="background: rgba(0,0,0,0.35); border-color: {{ $r['color'] }};">
                                    <span class="w-3 h-3 rounded-full" style="background: {{ $r['color'] }}; box-shadow: 0 0 8px {{ $r['color'] }}33"></span>
                                    <span class="rarity-label">{{ $r['label'] }}</span>
                                    <span class="rarity-check ml-2 hidden"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                                </button>
                            @endforeach

                            <div id="rarity-selected-badge" class="ml-3 px-3 py-1 rounded-full text-sm font-semibold hidden">
                                <!-- filled by JS -->
                            </div>
                        </div>
                        @error('rarity') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="px-4 py-2 bg-app-accent text-white rounded">Simpan Perubahan</button>
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-app-bg/60 text-app-muted rounded">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    (function(){
        // reuse the same JS as create view for rarity & category behavior
        const group = document.querySelector('[role="radiogroup"]');
        if(!group) return;
        const hidden = document.querySelector('input[name="rarity"]');
        const buttons = Array.from(group.querySelectorAll('.rarity-btn'));
        const preview = document.getElementById('rarity-selected-badge');

        function setSelected(btn){
            const val = btn.getAttribute('data-value');
            const color = btn.getAttribute('data-color') || '#ccc';
            if(hidden) hidden.value = val;
            buttons.forEach(b => {
                b.setAttribute('aria-checked', 'false');
                b.classList.remove('shadow-lg');
                b.style.boxShadow = '';
                b.style.borderColor = '';
                const check = b.querySelector('.rarity-check');
                if(check) check.classList.add('hidden');
            });
            btn.setAttribute('aria-checked','true');
            btn.classList.add('shadow-lg');
            btn.style.boxShadow = `0 8px 24px ${color}33`;
            btn.style.borderColor = color;
            const check = btn.querySelector('.rarity-check');
            if(check) check.classList.remove('hidden');

            if(preview){
                preview.classList.remove('hidden');
                preview.textContent = btn.querySelector('.rarity-label')?.textContent || val;
                preview.style.background = color;
                preview.style.color = (['#f59e0b','#fef3c7'].includes(color) ? '#000' : '#fff');
                preview.style.boxShadow = `0 6px 16px ${color}33`;
            }
        }

        // init selected from hidden input
        const initial = hidden ? hidden.value : null;
        if(initial){
            const found = buttons.find(b => b.getAttribute('data-value') === initial);
            if(found) setSelected(found);
        }

        buttons.forEach(btn => {
            btn.addEventListener('click', function(e){ setSelected(this); });
            btn.addEventListener('keydown', function(e){
                if(e.key === 'Enter' || e.key === ' '){ e.preventDefault(); setSelected(this); }
                const idx = buttons.indexOf(this);
                if(e.key === 'ArrowRight' || e.key === 'ArrowDown'){ const next = buttons[(idx + 1) % buttons.length]; next.focus(); }
                if(e.key === 'ArrowLeft' || e.key === 'ArrowUp'){ const prev = buttons[(idx - 1 + buttons.length) % buttons.length]; prev.focus(); }
            });
        });

        document.querySelectorAll('label.cursor-pointer').forEach(function(label){
            label.addEventListener('click', function(e){
                const radio = label.querySelector('input[type="radio"]');
                if(radio){
                    radio.checked = true;
                    document.querySelectorAll('label.cursor-pointer > span').forEach(function(span){ span.classList.remove('ring-2','ring-app-accent'); });
                    const badge = label.querySelector('span'); if(badge) badge.classList.add('ring-2','ring-app-accent');
                    const preview = document.getElementById('category-selected-preview');
                    if(preview){
                        const iconHtmlEl = label.querySelector('.cat-icon-html');
                        const nameEl = label.querySelector('.cat-name');
                        preview.innerHTML = '';
                        const iconWrap = document.createElement('span'); iconWrap.className = 'inline-flex items-center'; if(iconHtmlEl) iconWrap.innerHTML = iconHtmlEl.innerHTML;
                        const nameSpan = document.createElement('span'); nameSpan.className = 'ml-3 font-semibold'; nameSpan.textContent = nameEl ? nameEl.textContent : label.getAttribute('data-cat-name') || '';
                        preview.appendChild(iconWrap); preview.appendChild(nameSpan);
                    }
                }
            });
        });
    })();
</script>
@endpush
