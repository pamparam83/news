<?php

namespace core\repositories\Blog;

use core\entities\Blog\Post\Post;
use core\repositories\NotFoundException;

class PostRepository
{
    public function get($id)
    {
        if (!$brand = Post::findOne($id)) {
            throw new NotFoundException('Post is not found.');
        }
        return $brand;
    }

    public function existsByCategory($id)
    {
        return Post::find()->andWhere(['category_id' => $id])->exists();
    }

    public function save(Post $brand)
    {
        if (!$brand->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Post $brand)
    {
        if (!$brand->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}