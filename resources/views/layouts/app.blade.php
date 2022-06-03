<html>
    <head>
        <title>App Name - @yield('title')</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    </head>
    <body>
        @section('sidebar')
            This is the master sidebar.
        @show
 
        <div class="container mx-auto">
            @yield('content')
        </div>
    </body>
</html>