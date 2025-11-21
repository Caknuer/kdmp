<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'KDMP' }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 text-gray-800">

    @include('public.partials.navbar')

    <main class="min-h-screen">
        {{ $slot }}
    </main>

    @include('public.partials.footer')
    @yield('P')
</body>
</html>
