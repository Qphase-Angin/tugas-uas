<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>TEMA Admin | @yield('title')</title>

    <!-- Google Fonts: Inter (Modern Look) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Konfigurasi Tema Custom ala Tradeit.gg / TEMA Market -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        app: {
                            bg: '#0b0e14',       // Background Hitam Kebiruan
                            card: '#151a23',     // Background Card
                            cardHover: '#1c222e',
                            border: '#2a303c',   // Border Halus
                            text: '#e2e8f0',     // Teks Utama
                            muted: '#94a3b8',    // Teks Secondary
                            accent: '#3b82f6',   // Biru Elektrik (Tema Game/Tech)
                            accentHover: '#2563eb',
                            success: '#10b981',
                            danger: '#ef4444',
                            warning: '#f59e0b',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js (Untuk interaksi Sidebar/Dropdown tanpa jQuery berat) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Font Awesome (Tetap dipakai untuk ikon lama) -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}">

    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0b0e14; }
        ::-webkit-scrollbar-thumb { background: #2a303c; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #3b82f6; }

        /* Fix untuk library bawaan agar tidak putih mencolok */
        .toast { background-color: #151a23 !important; color: #fff !important; }

        /* Disable text selection across the admin layout to prevent blocking with cursor */
        /* Allow selection inside form controls so inputs remain editable/selectable */
        html, body, .min-h-screen, .flex-1, main, aside, nav, header, footer, .container-fluid, .bg-app-card, .bg-app-bg {
            -webkit-user-select: none !important;
            -moz-user-select: none !important;
            -ms-user-select: none !important;
            user-select: none !important;
        }

        /* Re-enable selection for interactive form elements */
        input, textarea, select, option, button {
            -webkit-user-select: text !important;
            -moz-user-select: text !important;
            -ms-user-select: text !important;
            user-select: text !important;
        }
    </style>
</head>

<body class="bg-app-bg text-app-text font-sans antialiased selection:bg-app-accent selection:text-white">

    <!-- x-data mengontrol state sidebar untuk mobile/desktop -->
    <div x-data="{ sidebarOpen: window.innerWidth >= 1024 }" class="min-h-screen flex flex-col">

        <!-- Navbar -->
        <header class="fixed top-0 w-full z-30">
            @include('admin.layout.navbar')
        </header>

        <div class="flex flex-1 pt-16">
            <!-- Sidebar -->
            <aside
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                class="fixed left-0 top-16 w-64 h-[calc(100vh-4rem)] bg-app-card border-r border-app-border transition-transform duration-300 ease-in-out z-20 lg:translate-x-0 overflow-y-auto">
                @include('admin.layout.sidebar')
            </aside>

            <!-- Main Content Wrapper -->
            <main
                :class="sidebarOpen ? 'lg:ml-64' : ''"
                class="flex-1 flex flex-col min-h-[calc(100vh-4rem)] transition-all duration-300 w-full">

                <!-- Breadcrumb Header -->
                <div class="px-6 py-4">
                    @include('admin.layout.header')
                </div>

                <!-- Content Body -->
                <div class="px-6 pb-6 flex-1">
                    @yield('content')
                </div>

                <!-- Footer -->
                <footer class="px-6 py-4 border-t border-app-border bg-app-card text-sm text-app-muted">
                    @include('admin.layout.footer')
                </footer>
            </main>
        </div>

        <!-- Overlay untuk Mobile saat sidebar terbuka -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-10 lg:hidden" style="display: none;"></div>
    </div>

    <!-- SCRIPTS -->
    <!-- jQuery (Masih dibutuhkan untuk Toastr/Datatables) -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>

    @stack('scripts')

    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
        }

        @if (Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif

        @if (Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif
    </script>
</body>
</html>
