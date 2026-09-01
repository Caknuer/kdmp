<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel KDMP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Smooth transitions */
        * { @apply transition-colors duration-300; }
        
        /* Sidebar collapsed state */
        .sidebar-collapsed .sidebar-text { @apply hidden; }
        .sidebar-collapsed .sidebar-logo span { @apply hidden; }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-rose-600 to-rose-700 text-white shadow-lg fixed h-screen overflow-y-auto">
            <!-- Logo -->
            <div class="p-6 border-b border-rose-500">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center group-hover:bg-white/30">
                        <i class="fas fa-crown text-lg"></i>
                    </div>
                    <span class="sidebar-logo font-bold text-lg">
                        <span>KDMP Admin</span>
                    </span>
                </a>
            </div>

            <!-- Navigation Menu -->
            <nav class="p-4 space-y-1.5">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 border-l-4 border-white' : 'hover:bg-white/10' }}">
                    <i class="fas fa-chart-line w-5"></i>
                    <span class="sidebar-text">Dashboard</span>
                </a>

                <!-- Pengurus -->
                <a href="{{ route('admin.pengurus.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.pengurus.*') ? 'bg-white/20 border-l-4 border-white' : 'hover:bg-white/10' }}">
                    <i class="fas fa-user-tie w-5"></i>
                    <span class="sidebar-text">Pengurus</span>
                </a>

                <!-- Pengawas -->
                <a href="{{ route('admin.pengawas.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.pengawas.*') ? 'bg-white/20 border-l-4 border-white' : 'hover:bg-white/10' }}">
                    <i class="fas fa-user-shield w-5"></i>
                    <span class="sidebar-text">Pengawas</span>
                </a>

                <!-- Anggota Koperasi -->
                <a href="{{ route('admin.members.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.members.*') ? 'bg-white/20 border-l-4 border-white' : 'hover:bg-white/10' }}">
                    <i class="fas fa-users w-5"></i>
                    <span class="sidebar-text">Anggota Koperasi</span>
                </a>

                <!-- Artikel -->
                <a href="{{ route('admin.articles.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.articles.*') ? 'bg-white/20 border-l-4 border-white' : 'hover:bg-white/10' }}">
                    <i class="fas fa-newspaper w-5"></i>
                    <span class="sidebar-text">Artikel</span>
                </a>

                <!-- Transaksi -->
                <a href="{{ route('admin.transactions.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.transactions.*') ? 'bg-white/20 border-l-4 border-white' : 'hover:bg-white/10' }}">
                    <i class="fas fa-money-bill-wave w-5"></i>
                    <span class="sidebar-text">Transaksi</span>
                </a>

                <!-- Mitra -->
                <a href="{{ route('admin.partners.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.partners.*') ? 'bg-white/20 border-l-4 border-white' : 'hover:bg-white/10' }}">
                    <i class="fas fa-handshake w-5"></i>
                    <span class="sidebar-text">Mitra</span>
                </a>

                <!-- Unit Bisnis -->
                <a href="{{ route('admin.business-units.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.business-units.*') ? 'bg-white/20 border-l-4 border-white' : 'hover:bg-white/10' }}">
                    <i class="fas fa-building w-5"></i>
                    <span class="sidebar-text">Unit Bisnis</span>
                </a>

                <!-- Halaman Tentang -->
                <a href="{{ route('admin.profile.about') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.profile.*') ? 'bg-white/20 border-l-4 border-white' : 'hover:bg-white/10' }}">
                    <i class="fas fa-file-alt w-5"></i>
                    <span class="sidebar-text">Halaman Tentang</span>
                </a>

                <!-- Pengaturan -->
                <a href="{{ route('admin.settings.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.settings.*') ? 'bg-white/20 border-l-4 border-white' : 'hover:bg-white/10' }}">
                    <i class="fas fa-sliders-h w-5"></i>
                    <span class="sidebar-text">Pengaturan</span>
                </a>
            </nav>

            <!-- Divider -->
            <div class="mx-4 border-t border-rose-500"></div>

            <!-- Logout -->
            <div class="p-4">
                <form method="POST" action="{{ route('admin.logout') }}" class="w-full">
                    @csrf
                    <button type="submit" 
                            class="flex items-center gap-3 px-4 py-3 rounded-lg w-full hover:bg-white/10 text-red-200 hover:text-white">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span class="sidebar-text">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 overflow-auto">
            <!-- Top Bar -->
            <header class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-40">
                <div class="px-8 py-4 flex items-center justify-between">
                    <!-- Title -->
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">@yield('page_title', 'Dashboard')</h1>
                        <p class="text-sm text-gray-500">@yield('page_subtitle', '')</p>
                    </div>

                    <!-- User Info -->
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <p class="font-semibold text-gray-800">{{ auth('admin')->user()->email }}</p>
                            <p class="text-xs text-gray-500">Admin User</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-rose-500 to-rose-600 flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr(auth('admin')->user()->email, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="p-8">
                <!-- Success/Error Messages -->
                @if ($message = Session::get('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
                    <i class="fas fa-check-circle text-green-600 mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-green-800">Berhasil!</h3>
                        <p class="text-green-700">{{ $message }}</p>
                    </div>
                </div>
                @endif

                @if ($message = Session::get('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3">
                    <i class="fas fa-exclamation-circle text-red-600 mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-red-800">Error!</h3>
                        <p class="text-red-700">{{ $message }}</p>
                    </div>
                </div>
                @endif

                @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <h3 class="font-semibold text-red-800 mb-2">Terjadi kesalahan validasi:</h3>
                    <ul class="text-red-700 space-y-1">
                        @foreach ($errors->all() as $error)
                        <li class="flex items-start gap-2">
                            <i class="fas fa-times-circle mt-1 flex-shrink-0"></i>
                            <span>{{ $error }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 px-8 py-6 text-center text-gray-600">
                <p>&copy; {{ date('Y') }} KDMP Wonokerto - Admin Panel. All rights reserved.</p>
            </footer>
        </main>
    </div>

    <script>
        // Simple toggle sidebar on mobile
        document.addEventListener('DOMContentLoaded', function() {
            // Add any additional scripts here
        });
    </script>
</body>
</html>
