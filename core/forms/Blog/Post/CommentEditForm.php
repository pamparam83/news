<?php

namespace core\forms\manage\Blog\Post;

use core\entities\Blog\Post\Comment;
use yii\base\Model;

class CommentEditForm extends Model
{
    public $parentId;
    public $text;

    public function __construct(Comment $comment, $config = [])
    {
        $this->parentId = $comment->parent_id;
        $this->text = $comment->text;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['text'], 'required'],
            ['text', 'string'],
            ['parentId', 'integer'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'text' => 'Текст',
            'parentId' => 'Категория',
        ];
    }
}