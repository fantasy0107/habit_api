<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TopicCollection;
use App\Http\Resources\TopicResource;
use App\Models\TargetTag;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $topics = $user->topics;

        $tags = collect();

        $response = [
            'topic_id' => $topics->pluck('id')
        ];

        if ($request->target_id) {
            $tags = $user->targetTags()->where('target_id',  $request->target_id)->get();
            $response['tag_id'] = $tags->pluck('id');
            $response['db']['target_tag'] = $tags->keyBy('id');
        }


        $response['db']['topic'] =  $topics->map(function ($topic) use ($tags) {
            $tagIDs = [];

            $tags->each(function ($tag) use ($topic, &$tagIDs) {
                if (str_contains($topic->content, "#$tag->name")) {
                    $tagIDs[] = $tag->id;
                }
            });

            $topic->tag_id = $tagIDs;

            return $topic;
        })->keyBy('id');



        return $this->ok($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required'
        ]);

        $user = Auth::user();
        $topic = new Topic;
        $topic->user_id = $user->id;
        $topic->title = $request->input('title', '預設');
        $topic->content = $request->input('content', '預設');
        $topic->save();

        return new TopicResource($topic);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $topic = Topic::find($id);

        if (!$topic) {
            abort(400, '找不到');
        }

        $update = false;
        if ($request->content && $request->content !=  $topic->content) {
            $topic->content = $request->content;
            $update  = true;
        }

        if ($request->title && $request->title !=  $topic->title) {
            $topic->title = $request->title;
            $update  = true;
        }

        if ($update) {
            $topic->save();
        }

        return $this->ok([
            'topic' => $topic
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
