<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'KDMP Wonokerto' }}</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<body class="pt-20 bg-gray-50 text-gray-800">

    @include('public.partials.navbar')

    <main class="min-h-screen">

        @yield('P')
    </main>

    @include('public.partials.footer')
</body>
</html>
