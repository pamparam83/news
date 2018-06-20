<?php
namespace core\entities\Blog\Post;

use yii\db\ActiveRecord;

/**
 * @property integer $post_id;
 * @property integer $tag_id;
 */
class TagAssignment extends ActiveRecord
{
    public static function create($tagId): self
    {
        $assignment = new static();
        $assignment->tag_id = $tagId;
        return $assignment;
    }

    public function isForTag($id)
    {
        return $this->tag_id == $id;
    }

    public static function tableName()
    {
        return '{{%blog_tag_assignments}}';
    }
}