<div class="flex flex-1 flex-col">
    <nav class="px-4 flex flex-row  justify-end bg-white h-16 border-b-2">

        @auth
            <div>
                <a href="{{  route('tasks.index')  }}">Todo</a>
            </div>
            <div>
            {{ auth()->user()->name }}
            </div>
        @endauth

        @guest
            <a href="{{ route('login.index') }}">登入</a>
        @endguest

    </nav>
</div>