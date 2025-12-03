<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'KDMP Wonokerto' }}</title>

    <!-- Load CSS Manual -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    @include('public.partials.navbar')

    <main class="main-content">
        @yield('P')
    </main>

    @include('public.partials.footer')

</body>
</html>
