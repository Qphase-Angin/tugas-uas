@extends('user.layout.main')

@section('title','Catalog')

@section('content')
<div x-data="{ openPanel: null }" x-cloak>
    <!-- Welcome Banner (mirip dashboard) -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-app-card to-[#1e2532] border border-app-border p-8 mb-8 shadow-xl">
        <div class="relative z-10">
            <h1 class="text-3xl font-bold text-white mb-2">
                <span class="app-accent">Product Catalog</span>
            </h1>
            <p class="app-text-muted">
                Explore the latest <span class="font-semibold text-white">TEMAN Market</span> collection. Click a card to view full details.
            </p>
        </div>
        <div class="absolute -right-10 -top-20 w-64 h-64 bg-orange-500/10 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Search & Filter -->
    <div class="flex gap-4 mb-6 flex-wrap items-center">
        <div class="flex-1 min-w-[250px]">
            <input type="text" id="search" placeholder="Search products..."
                class="w-full bg-app-card border border-app-border rounded-lg px-4 py-2.5 text-white placeholder-app-muted focus:border-orange-500 focus:outline-none">
        </div>
        <button class="btn" onclick="document.getElementById('search').value='';document.getElementById('search').dispatchEvent(new Event('input'))">
            <i class="fas fa-refresh mr-2"></i>Reset
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
            <div class="app-card border border-app-border p-5 rounded-xl hover:border-orange-500/30 transition-all duration-300">
            <div class="flex items-start justify-between mb-2">
                <p class="app-text-muted text-xs font-bold uppercase tracking-wider">Total Products</p>
                <div class="p-2 bg-[#0b0e11] rounded-lg text-orange-500">
                    <i class="fas fa-box"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-white mb-1" id="totalCount">0</h3>
            <span class="text-xs font-medium text-green-500">Available</span>
        </div>

        <div class="app-card border border-app-border p-5 rounded-xl hover:border-orange-500/30 transition-all duration-300">
            <div class="flex items-start justify-between mb-2">
                <p class="app-text-muted text-xs font-bold uppercase tracking-wider">Categories</p>
                <div class="p-2 bg-[#0b0e11] rounded-lg text-blue-500">
                    <i class="fas fa-tag"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-white mb-1" id="categoryCount">0</h3>
            <span class="text-xs font-medium text-purple-500">Total</span>
        </div>

        <div class="app-card border border-app-border p-5 rounded-xl hover:border-orange-500/30 transition-all duration-300 md:col-span-2 lg:col-span-2">
            <div class="flex items-start justify-between mb-2">
                <p class="app-text-muted text-xs font-bold uppercase tracking-wider">Active Filter</p>
                <div class="p-2 bg-[#0b0e11] rounded-lg text-yellow-500">
                    <i class="fas fa-filter"></i>
                </div>
            </div>
                <div id="activeFilter" class="text-sm text-white">
                <span id="filterText" class="text-green-500">All categories displayed</span>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="catalogGrid">
            @isset($items)
                @forelse($items as $item)
                    <div class="card app-card border border-app-border rounded-xl p-4 hover:border-orange-500/50 hover:shadow-lg hover:shadow-orange-500/20 transition-all duration-300"
                        data-item-title="{{ $item->name }}"
                        data-item-desc="{{ Str::limit($item->description ?? '', 500) }}"
                        data-item-price="{{ $item->price ?? '-' }}"
                        data-item-image="{{ $item->image ? asset('storage/'.$item->image) : '' }}"
                        data-category="{{ $item->category->name ?? 'Umum' }}">
                        <img src="{{ $item->image ? asset('storage/'.$item->image) : 'https://via.placeholder.com/240x160?text=No+Image' }}"
                            alt="{{ $item->name }}"
                            class="rounded-lg border border-app-border">
                        <div class="flex-1">
                            <div class="font-bold text-white text-base">{{ $item->name }}</div>
                            <div class="app-text-muted text-xs mt-1">{{ Str::limit($item->description ?? '-', 80) }}</div>
                            <div class="app-text-muted text-xs mt-1">
                                <i class="fas fa-folder mr-1"></i>{{ $item->category->name ?? 'General' }}
                            </div>
                            <div class="mt-3 font-bold text-orange-500">{{ $item->price ?? '-' }}</div>
                        </div>
                    </div>
                @empty
                    <p class="app-text-muted col-span-full text-center py-8">No items.</p>
                @endforelse
            @else
                @php
                    $samples = [
                        ['name'=>'Kemeja Batik','desc'=>'Kemeja batik lengan panjang, bahan adem.','price'=>'Rp120.000','category'=>'Pakaian','img'=>'https://via.placeholder.com/240x160?text=Kemeja'],
                        ['name'=>'Tas Ransel','desc'=>'Ransel multifungsi untuk sehari-hari.','price'=>'Rp220.000','category'=>'Aksesori','img'=>'https://via.placeholder.com/240x160?text=Ransel'],
                        ['name'=>'Sepatu Olahraga','desc'=>'Sepatu nyaman untuk lari dan gym.','price'=>'Rp350.000','category'=>'Sepatu','img'=>'https://via.placeholder.com/240x160?text=Sepatu'],
                        ['name'=>'Jaket Denim','desc'=>'Jaket denim klasik, nyaman dipakai.','price'=>'Rp280.000','category'=>'Pakaian','img'=>'https://via.placeholder.com/240x160?text=Jaket'],
                    ];
                @endphp
                @foreach($samples as $s)
                    <div class="card app-card border border-app-border rounded-xl p-4 hover:border-orange-500/50 hover:shadow-lg hover:shadow-orange-500/20 transition-all duration-300"
                        data-item-title="{{ $s['name'] }}"
                        data-item-desc="{{ $s['desc'] }}"
                        data-item-price="{{ $s['price'] }}"
                        data-item-image="{{ $s['img'] }}"
                        data-category="{{ $s['category'] }}">
                        <img src="{{ $s['img'] }}" alt="{{ $s['name'] }}" class="rounded-lg border border-app-border">
                        <div class="flex-1">
                            <div class="font-bold text-white text-base">{{ $s['name'] }}</div>
                            <div class="app-text-muted text-xs mt-1">{{ Str::limit($s['desc'], 80) }}</div>
                            <div class="app-text-muted text-xs mt-1">
                                <i class="fas fa-folder mr-1"></i>{{ $s['category'] }}
                            </div>
                            <div class="mt-3 font-bold text-orange-500">{{ $s['price'] }}</div>
                        </div>
                    </div>
                @endforeach
            @endisset
        </div>
    </div>
</div>

<script>
    // Update stats
    function updateStats() {
        var cards = document.querySelectorAll('#catalogGrid .card');
        var visible = 0;
        var categories = new Set();

        cards.forEach(function(card) {
            if(card.style.display !== 'none') visible++;
            categories.add(card.dataset.category);
        });

        document.getElementById('totalCount').textContent = visible;
        document.getElementById('categoryCount').textContent = categories.size;
    }

    // Search filter
    document.getElementById('search').addEventListener('input', function(e){
        var q = e.target.value.toLowerCase();
        var cards = document.querySelectorAll('#catalogGrid .card');

        cards.forEach(function(card){
            var t = (card.dataset.itemTitle || '').toLowerCase();
            var d = (card.dataset.itemDesc || '').toLowerCase();
            var c = (card.dataset.category || '').toLowerCase();
            var match = t.indexOf(q) !== -1 || d.indexOf(q) !== -1 || c.indexOf(q) !== -1;
            card.style.display = match ? '' : 'none';
        });

        updateStats();
    });

    // Initial stats
    updateStats();
</script>

@endsection
