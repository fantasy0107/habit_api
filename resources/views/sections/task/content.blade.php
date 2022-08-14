@if(isset($tasks))


    <div id="content" class="flex flex-1 flex-col p-6">
        @foreach ($tasks as $task)
            <div id="task-{{ $task->id }}" class="flex">
                <button onclick="clickTaskDone({{ $task->id }})">x</button>
                <div>{{ $task->title }}</div>
            </div>
        @endforeach
    </div>

@endif

<script type="text/javascript">
    function clickTaskDone(id) {
        const taskId = '#task-'+id;
        console.log('clickProject', taskId);
        $(taskId).remove();
        // axios.get('/projects/' + id + '/tasks', {
        //     params: {type}
        // }).then((data) => {
        //     console.log('data', data);
        //     $('#content').html(data.data);
        // })
    }
</script>

