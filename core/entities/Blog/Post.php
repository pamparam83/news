<?php

namespace core\entities\Blog;

use core\entities\Blog\Post\queries\PostQuery;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property integer $id
 * @property integer $created_at
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $photo
 * @property integer $status
 *
 * @mixin ImageUploadBehavior
 */
class Post extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    public $meta;

    public static function create($title, $description, $content)
    {
        $post = new static();
        $post->title = $title;
        $post->description = $description;
        $post->content = $content;
        $post->status = self::STATUS_DRAFT;
        $post->created_at = time();
        return $post;
    }

    public function setPhoto(UploadedFile $photo)
    {
        $this->photo = $photo;
    }


    public function edit($title, $description, $content)
    {
        $this->title = $title;
        $this->description = $description;
        $this->content = $content;
    }

    public function activate()
    {
        if ($this->isActive()) {
            throw new \DomainException('Post is already active.');
        }
        $this->status = self::STATUS_ACTIVE;
    }

    public function draft()
    {
        if ($this->isDraft()) {
            throw new \DomainException('Post is already draft.');
        }
        $this->status = self::STATUS_DRAFT;
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }


    public function isDraft()
    {
        return $this->status == self::STATUS_DRAFT;
    }


    public static function tableName()
    {
        return '{{%blog_posts}}';
    }

    public function behaviors()
    {
        return [

            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'photo',
                'createThumbsOnRequest' => true,
                'filePath' => '@app/uploads/origin/posts/[[id]].[[extension]]',
                'fileUrl' => '@app/uploads/origin/posts/[[id]].[[extension]]',
                'thumbPath' => '@app/uploads/cache/posts/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@app/uploads/cache/posts/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 640, 'height' => 480],
                    'blog_list' => ['width' => 700, 'height' => 300],
                    'widget_list' => ['width' => 228, 'height' => 228],
                ],
            ],
        ];
    }

    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find(): PostQuery
    {
        return new PostQuery(static::class);
    }
}