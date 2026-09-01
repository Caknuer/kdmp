{{-- resources/views/layouts/public.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- =========================
        TITLE (Dynamic per page)
    ========================= --}}
    @php
        $siteName = setting('site_name') ?: 'KDMP Wonokerto';
        $pageTitle = $pageTitle ?? null;
        $fullTitle = $pageTitle ? "{$pageTitle} | {$siteName}" : $siteName;
    @endphp
    <title>{{ $fullTitle }}</title>

    {{-- SEO Meta Tags --}}
    <meta name="description" content="{{ $pageDescription ?? 'Koperasi Desa Merah Putih (KDMP) Wonokerto - Mengelola potensi desa secara transparan, profesional, dan berkelanjutan demi kesejahteraan bersama.' }}">
    <meta name="keywords" content="{{ $pageKeywords ?? 'koperasi, desa, wonokerto, kdmp, simpan pinjam, UMKM' }}">
    <meta name="author" content="KDMP Wonokerto">
    <meta name="robots" content="index, follow">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $fullTitle }}">
    <meta property="og:description" content="{{ $pageDescription ?? 'Koperasi Desa Merah Putih Wonokerto' }}">
    <meta property="og:image" content="{{ asset('images/kdmp.png') }}">

    {{-- Twitter --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $fullTitle }}">
    <meta property="twitter:description" content="{{ $pageDescription ?? 'Koperasi Desa Merah Putih Wonokerto' }}">
    <meta property="twitter:image" content="{{ asset('images/kdmp.png') }}">

    {{-- CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- =========================
        FAVICON (dynamic)
    ========================= --}}
    @php
        $favicon = setting('site_favicon');
        $favicon = $favicon ? ltrim($favicon, '/') : null;
        $faviconUrl = $favicon ? asset('storage/' . $favicon) : asset('favicon.ico');
        $faviconType = null;
        if ($favicon) {
            $ext = strtolower(pathinfo($favicon, PATHINFO_EXTENSION));
            $faviconType = match ($ext) {
                'png' => 'image/png',
                'ico' => 'image/x-icon',
                default => null,
            };
        }
    @endphp
    <link rel="icon" href="{{ $faviconUrl }}" @if($faviconType) type="{{ $faviconType }}" @endif>

    {{-- Preconnect untuk performa --}}
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- Page-specific styles --}}
    @stack('styles')

    {{-- Page-specific head scripts --}}
    @stack('head-scripts')
</head>

<body>
    @include('components.batik')

    {{-- Navbar --}}
    @include('public.partials.navbar')

    {{-- Main Content --}}
    <main id="main-content">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('public.partials.footer')

    {{-- Toast Notification Container --}}
    @include('public.partials.toast')

    {{-- =========================
        JS
    ========================= --}}
    <script src="{{ asset('js/app.js') }}"></script>

    {{-- Page-specific scripts --}}
    @stack('scripts')
</body>
</html>

