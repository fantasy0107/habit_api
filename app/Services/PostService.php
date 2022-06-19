<?php

namespace App\Services;

use App\Repositories\PostRepository;

class PostService
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function savePost($input)
    {
        $postData = [
            'post' => $input['post']
        ];

        if (isset($input['id'])) {
            $postData['id'] = $input['id'];
        }

        $post = $this->postRepository->save([
            'post' => $postData['post']
        ]);

        return [
            'post' => $post
        ];
    }
}
