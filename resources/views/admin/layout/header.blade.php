<div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-white tracking-tight">@yield('title')</h1>
        <p class="text-xs text-app-muted mt-1">Manage your library marketplace efficiently</p>
    </div>

    <ol class="flex items-center text-sm text-app-muted bg-app-card border border-app-border px-4 py-2 rounded-full shadow-sm">
        <li class="flex items-center hover:text-white transition-colors">
            <a href="{{ route('admin.dashboard') }}">{{ ucfirst(Request::segment(1)) }}</a>
        </li>

        @for ($i = 2; $i <= 3; $i++)
            @php
                $segment = Request::segment($i);
            @endphp
            @if($segment)
                <li class="flex items-center">
                    <i class="fas fa-chevron-right text-[10px] mx-3 opacity-50"></i>
                    @php
                        $formattedSegment = ucwords(str_replace('-', ' ', $segment));
                        // Perbaikan: Cek manual apakah ini segmen terakhir
                        $isActive = $i == count(Request::segments());
                    @endphp
                    <span class="{{ $isActive ? 'text-app-accent font-medium' : 'hover:text-white transition-colors' }}">
                        {{ $formattedSegment }}
                    </span>
                </li>
            @endif
        @endfor
    </ol>
</div>
<div class="h-px bg-app-border w-full mt-6 opacity-50"></div>
