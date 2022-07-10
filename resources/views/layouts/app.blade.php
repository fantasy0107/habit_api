<html>

<head>
    @include('sections.head')
</head>

<body>
<div class="h-screen w-screen">
    <header>
        @include('sections.topbar')
    </header>
    <div class="container mx-auto">
        <div class="flex flex-1">
            <div class="w-1/4">
            </div>
            <div class="flex flex-1 mx-auto justify-center">
                @yield('content')
            </div>
            <div class="w-1/4">
            </div>
        </div>
    </div>
</div>
</body>

</html>
