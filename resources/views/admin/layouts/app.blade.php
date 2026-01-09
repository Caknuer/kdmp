<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Admin KDMP')</title>
</head>
<body>

    @include('admin.partials.navbar')

    <div style="display:flex;">
        @include('admin.partials.sidebar')

        <div style="padding:20px; flex:1;">
            @yield('content')
        </div>
    </div>

</body>
</html>
