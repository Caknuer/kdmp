<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ setting('site_name') }}</title>

    <!-- Load CSS Manual -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>

<body>

    @include('public.partials.navbar')

    <main class="main-content">
        @yield('P')
    </main>

    @include('public.partials.footer')
    
    <div class="modal" id="orgModal">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <img id="orgPhoto">
            <h3 id="orgName"></h3>
            <p id="orgRole"></p>
            <p id="orgBio"></p>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
