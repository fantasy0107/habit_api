<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }


    public function getByFilter($filter)
    {
        $query = $this->post->newQuery();

        return $query->get();
    }

    public function save($data)
    {
        $post = new Post;
        if (isset($data['id'])) {
            $post = Post::findOrFail($data['id']);
        }

        $post->fill($data['post']);
        $post->save();

        return $post;
    }
}
