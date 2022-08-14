<button
        id="project-{{ $id }}"
        class="hover:bg-gray-400 text-left"
        onclick="clickProject({{ $type }}, '{{ $id }}')">
    {{ $title }}
</button>

<script type="text/javascript">
    function clickProject(type, id) {
        console.log('clickProject', type, id);
        axios.get('/projects/'+id+'/tasks', {
            params:{type}
        }).then((data) => {
            console.log('data', data);
            $('#content').html(data.data);
        })
    }
</script>