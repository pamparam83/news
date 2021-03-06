<?php

namespace core\forms\news;

use core\entities\News;
use yii\base\Model;
use yii\web\UploadedFile;

class NewsEditForm extends Model
{
    public $title;
    public $description;
    public $content;
    public $photo;
    public $id;

    public function __construct(News $post = null, $config = [])
    {
        if ($post) {
            $this->title = $post->title;
            $this->description = $post->description;
            $this->content = $post->content;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['description', 'content'], 'string'],
            [['photo'], 'image'],
        ];
    }


    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->photo = UploadedFile::getInstance($this, 'photo');
            return true;
        }
        return false;
    }
}