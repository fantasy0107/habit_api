@extends('layouts.app')

@section('title', 'Page Title')


@section('content')

<div id="{{ 'post_'.$id }}" class="w-screen h-screen">
    <form id='post_edit_form' method='post' action='/posts/{{ $id }}'>
        @method('PUT')
        @csrf

        <label>標題</label>
        <input 
            id='post_{{ $id }}_title' 
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2" type="text" 
            value="{{ $title }}"
            name='title'
        ></input>
        <label>內容</label>
        <textarea id='simple_markdown_editor' name='description'></textarea>
        <button id='post_{{ $id }}_submit' class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            更改
        </button>
    </form>
</div>



<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
<script>
    let simplemde = new SimpleMDE({
        element: document.getElementById("simple_markdown_editor"),
        initialValue: '{{ $description }}'
    })

    $(document).ready(function() {
        $('#post_{{ $id }}_submit').on('click', (e) => {
            $('#post_edit_form').submit();
        })
    })
</script>
@endsection