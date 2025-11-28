<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'KDMP Wonokerto' }}</title>
    {{-- @vite('resources/css/app.css') --}}
    <link rel="stylesheet" href="/css/app.css">
</head>
<body class="bg-gray-50 text-gray-800">

    @include('public.partials.navbar')

    <main class="min-h-screen">
        {{-- {{ $slot }} --}}
        @yield('P')
    </main>

    @include('public.partials.footer')
</body>
</html>
