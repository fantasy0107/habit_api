<div class="flex flex-1 flex-col">
    <nav class="px-4 flex flex-row  justify-end bg-white h-16 border-b-2">
        <div >
        @auth
            {{ auth()->user()->name }}
        @endauth

        @guest
            <a href="{{ route('login.index') }}" >登入</a>
        @endguest
        </div>
    </nav>
</div>