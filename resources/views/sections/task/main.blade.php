@extends('layouts.task')

@section('topbar')
    @include('sections.task.topbar')
@endsection

@section('sidebar')
    @include('sections.task.sidebar')
@endsection

@section('content')
    <div class="flex flex-col flex-1 ">
        @include('sections.task.content')
    </div>
@endsection