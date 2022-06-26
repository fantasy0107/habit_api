<html>

<head>
    <title>App Name - @yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</head>

<body>
    @include('sections.topbar')
    <div class="flex flex-1 flex-col container mx-auto justify-center w-screen">
        @yield('content')
    </div>
</body>

</html>