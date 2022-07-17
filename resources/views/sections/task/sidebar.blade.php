<aside class="w-1/3 flex flex-col">
    @foreach ($projects as $project)
        <button id="project-{{ $project->id }}" class="hover:bg-gray-400" onclick="clickProject({{ $project->id }})">{{ $project->title }}</button>
    @endforeach
</aside>

<script type="text/javascript">
        function clickProject(id)
        {
                console.log(id);
        }
</script>