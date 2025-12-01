<!-- Logo Area -->
<div class="h-16 flex items-center px-6 border-b border-app-border bg-app-bg/50 sticky top-0 z-10">
    <a href="#" class="flex items-center gap-3 group">
        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-app-accent to-app-accent/70 flex items-center justify-center shadow-lg shadow-app-accent/20 group-hover:scale-110 transition-transform">
            <i class="fas fa-gamepad text-white text-sm"></i>
        </div>
        <div>
            <h1 class="text-white font-bold text-lg leading-none tracking-tight group-hover:text-app-accent transition-colors">TEMAN</h1>
            <span class="text-[10px] text-app-muted uppercase tracking-widest">Admin Dashboard</span>
        </div>
    </a>
</div>

<!-- Menu -->
<nav class="p-4">
    <ul class="space-y-1">

        <!-- Dashboard -->
        <li>
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200
               {{ request()->is('admin/dashboard') ? 'bg-app-accent text-white shadow-lg shadow-app-accent/20' : 'text-app-muted hover:text-white hover:bg-app-cardHover' }}">
                <i class="nav-icon fas fa-th w-5 text-center"></i>
                <p>Dashboard</p>
            </a>
        </li>

        <!-- Data Master (Treeview dengan Alpine) -->
        <li x-data="{ expanded: {{ request()->is('admin/kategori*') || request()->is('admin/buku*') || request()->is('admin/user*') || request()->is('admin/items*') ? 'true' : 'false' }} }">
            <button
                @click="expanded = !expanded"
                class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium text-app-muted hover:text-white hover:bg-app-cardHover transition-all">
                <div class="flex items-center gap-3">
                    <i class="fas fa-folder-open w-5 text-center"></i>
                    <span>Market Data</span>
                </div>
                <i class="fas fa-chevron-right text-xs transition-transform duration-200" :class="expanded ? 'rotate-90' : ''"></i>
            </button>

            <!-- Submenu -->
            <ul x-show="expanded"
                x-collapse
                class="mt-1 ml-2 space-y-1 border-l border-app-border pl-2">

                <!-- Menggunakan route yang sama tapi tampilan teks berbeda -->
                <li>
                    <a href="{{ route('admin.items.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150 {{ request()->is('admin/items') ? 'bg-app-accent text-white shadow-lg shadow-app-accent/20' : 'text-app-muted hover:text-app-accent hover:bg-app-cardHover' }}">
                        <i class="fas fa-tags w-4 text-center text-xs"></i>
                        <p>Browse Items</p>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.items.create') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150 {{ request()->is('admin/items/create') ? 'bg-app-accent text-white shadow-lg shadow-app-accent/20' : 'text-app-muted hover:text-app-accent hover:bg-app-cardHover' }}">
                        <i class="fas fa-box-open w-4 text-center text-xs"></i>
                        <p>Add Item</p>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-app-muted hover:text-app-accent hover:bg-app-cardHover transition-colors">
                        <i class="fas fa-users w-4 text-center text-xs"></i>
                        <p>Traders</p> <!-- Trade -->
                    </a>
                </li>
            </ul>
        </li>

    </ul>

    <!-- Promo / Info Box Kecil -->
    <div class="mt-8 p-4 rounded-xl bg-gradient-to-br from-app-cardHover to-app-bg border border-app-border">
        <div class="flex items-center gap-2 mb-2">
            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
            <span class="text-xs font-semibold text-white">Bot Network</span>
        </div>
        <p class="text-[10px] text-app-muted leading-relaxed">Trading bots online. Steam API latency: 45ms.</p>
    </div>
</nav>
