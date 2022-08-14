<aside class="w-1/3 flex flex-col bg-background pl-6 pr-1 py-1 ">
    @include('components.sideBarButton', [
            'id' => 'box',
            'type' => \App\Constant\ProjectConstant::PROJECT_TYPE_BOX,
            'title' => '收件箱'
        ])
    @include('components.sideBarButton', [
            'id' => 'box',
            'type' => \App\Constant\ProjectConstant::PROJECT_TYPE_TODAY,
            'title' => '今天'
        ])
    <div class="mt-6">項目</div>
    @foreach ($projects as $project)
        @if($project->type == 0)
            @include('components.sideBarButton', [
                'id' => $project->id,
                'type' => 0,
                'title' => $project->title
            ])
        @endif
    @endforeach
</aside>