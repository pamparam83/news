<?php

namespace core\entities\Blog\Post;

use core\entities\Blog\Post\queries\PostQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $created_at
 * @property int $post_id
 * @property int $user_id
 * @property int $parent_id
 * @property string $text
 * @property bool $active
 *
 * @property Post $post
 */
class Comment extends ActiveRecord
{
    public static function create($userId, $parentId, $text)
    {
        $review = new static();
        $review->user_id = $userId;
        $review->parent_id = $parentId;
        $review->text = $text;
        $review->created_at = time();
        $review->active = true;
        return $review;
    }

    public function edit($parentId, $text)
    {
        $this->parent_id = $parentId;
        $this->text = $text;
    }

    public function activate()
    {
        $this->active = true;
    }

    public function draft()
    {
        $this->active = false;
    }

    public function isActive()
    {
        return $this->active == true;
    }

    public function isIdEqualTo($id)
    {
        return $this->id == $id;
    }

    public function isChildOf($id)
    {
        return $this->parent_id == $id;
    }

    public function getPost()
    {
        return $this->hasOne(Post::class, ['id' => 'post_id']);
    }

    public static function tableName()
    {
        return '{{%blog_comments}}';
    }
}