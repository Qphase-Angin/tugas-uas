<nav class="bg-app-card/80 backdrop-blur-md border-b border-app-border h-16 flex items-center justify-between px-4 lg:px-6">
    <div class="flex items-center gap-4">
        <a href="/" class="flex items-center gap-3">
            <i class="fas fa-crosshairs text-app-accent animate-pulse text-2xl drop-shadow-md"></i>
            <div class="leading-none">
                <div class="text-lg font-rajdhani font-bold text-white tracking-wider">TEMAN</div>
                <div class="text-xs text-app-muted">Marketplace</div>
            </div>
        </a>

        <div class="hidden lg:flex items-center ml-6 gap-3">
            <a href="{{ route('user.index') }}" class="btn ghost px-3 py-2 text-sm">
                <i class="fas fa-th-large mr-2 text-sm"></i> Katalog
            </a>
            <a href="#" class="btn ghost px-3 py-2 text-sm">
                <i class="fas fa-tags mr-2 text-sm"></i> Kategori
            </a>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <div class="hidden sm:flex items-center bg-app-card border border-app-border rounded-full px-3 py-1.5 gap-3">
            <i class="fas fa-search text-app-muted"></i>
            <input type="text" placeholder="Search" class="bg-transparent outline-none text-sm text-white placeholder-app-muted w-40">
        </div>

        <div class="flex items-center gap-3">
            <a href="#" class="text-app-muted hover:text-white transition-colors relative">
                <i class="fas fa-bell text-lg"></i>
                <span class="absolute -top-1 -right-2 w-2.5 h-2.5 bg-app-accent rounded-full animate-pulse"></span>
            </a>

            @auth
                <div class="flex items-center gap-2">
                    <span class="text-sm app-text-muted hidden sm:inline">{{ Auth::user()->name ?? Auth::user()->nama }}</span>
                    <a href="{{ route('logout') }}" class="btn ghost px-3 py-2 text-sm">Logout</a>
                </div>
            @else
                <button id="openLogin" class="btn px-3 py-2 text-sm">Login</button>
                <button id="openRegister" class="btn ghost px-3 py-2 text-sm">Register</button>
            @endauth
        </div>
    </div>
</nav>
