<html>
@include('sections.head')
<body>
<div class="h-screen w-screen flex flex-1 flex-col">
    <div>
        @yield('topbar')
    </div>
    <div class="flex flex-1">
        @yield('sidebar')
        @yield('content')
    </div>
</div>
</body>
</html>
