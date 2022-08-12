<?php

namespace App\Http\Controllers\Api;

use App\Constant\PostConstant;
use App\Http\Controllers\Controller;
use App\Http\Resources\CreatePostResource;
use App\Http\Resources\DestroyPostResource;
use App\Http\Resources\ShowPostResource;
use App\Http\Resources\UpdatePostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        return CreatePostResource::collection($user->posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $user = Auth::user();

        $postData = $request->all();
        $postData['user_id'] = $user->id;

        $response = $this->postService->savePost([
            'post' => $postData
        ]);

        return new CreatePostResource($response['post']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return new ShowPostResource($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'status' => Rule::in([PostConstant::POST_STATUS_DEFAULT, PostConstant::POST_STATUS_DELETE, PostConstant::POST_STATUS_PUBLISH]),
            'title' => 'string',
            'description' => 'string',
            'img' => 'url'
        ]);

        $post->fill($request->all());
        $post->save();

        return new UpdatePostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->status = PostConstant::POST_STATUS_DELETE;
        $post->delete();

        return new DestroyPostResource(null);
    }
}
