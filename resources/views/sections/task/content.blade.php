@if(isset($tasks))
    <div>
        @foreach ($tasks as $task)
            <p>This is user {{ $task->name }}</p>
        @endforeach
    </div>
@endif

