<?php

namespace core\repositories\Blog;

use core\entities\Blog\Post;

class PostRepository
{
    public function get($id)
    {
        if (!$post = Post::findOne($id)) {
            throw new \DomainException('Post is not found.');
        }
        return $post;
    }

    public function save(Post $post)
    {
        if (!$post->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Post $post)
    {
        if (!$post->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}