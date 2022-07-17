<html>
@include('sections.head')
<body>
<div class="h-screen w-screen">
    @yield('topbar')
    <div class="flex flex-1">
        @yield('sidebar')
        @yield('content')
    </div>
</div>
</body>
</html>
