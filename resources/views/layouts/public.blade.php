{{-- resources/views/layouts/public.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- =========================
        TITLE (fallback dummy)
    ========================= --}}
    @php
        $siteName = setting('site_name') ?: 'KDMP';
    @endphp
    <title>{{ $siteName }}</title>

    {{-- CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- =========================
        FAVICON (dynamic)
        value DB: "site/favicon.png" / "site/favicon.ico"
    ========================= --}}
    @php
        $favicon = setting('site_favicon');

        // amanin kalau ada leading slash
        $favicon = $favicon ? ltrim($favicon, '/') : null;

        $faviconUrl = $favicon
            ? asset('storage/' . $favicon)
            : asset('favicon.ico');

        // optional: type favicon
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

    {{-- =========================
        CSS
    ========================= --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- OPTIONAL: kalau kamu pakai font --}}
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com"> --}}
</head>

<body>

    {{-- Navbar --}}
    @include('public.partials.navbar')

    {{-- Main Content
         NOTE: sengaja tidak dibungkus container di layout
         biar hero/page-hero bisa full width
    --}}
    <main>
        @yield('P')
    </main>

    {{-- Footer --}}
    @include('public.partials.footer')

    {{-- =========================
        JS
    ========================= --}}

    {{-- Chart.js hanya kalau ada canvas financeChart (biar hemat load) --}}
    <script>
        window.__needsChart = !!document.getElementById('financeChart');
    </script>
    <script>
        (function(){
            if(!window.__needsChart) return;
            var s=document.createElement('script');
            s.src='https://cdn.jsdelivr.net/npm/chart.js';
            s.defer=true;
            document.head.appendChild(s);
        })();
    </script>

    <script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
