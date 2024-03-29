@extends('layouts.app')

@section('title', 'Page Title')

@section('sidebar')
@parent
<p>This is appended to the master sidebar.</p>
@endsection

@section('content')
<div class="flex flex-1 flex-col">
    @include('sections.post')

    <div id='blog_list' class="flex flex-col">
        @isset($posts)
            @foreach ($posts as $post)
                @include('sections.postCard', [
                    'id' => $post->id,
                    'title' => $post->title,
                    'description' => $post->description
                ])
            @endforeach
        @endisset
    </div>
</div>
@endsection
