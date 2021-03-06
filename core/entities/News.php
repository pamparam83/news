<?php
namespace core\entities;

use core\entities\queries\NewsQuery;
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
 * @property integer $author
 *
 * @mixin ImageUploadBehavior
 */
class News extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;


    public static function create($title, $description, $content)
    {
        $news = new static();
        $news->title = $title;
        $news->description = $description;
        $news->content = $content;
        $news->status = self::STATUS_ACTIVE;
        $news->created_at = time();
        $news->author = \Yii::$app->user->id;
        return $news;
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
            throw new \DomainException('News is already active.');
        }
        $this->status = self::STATUS_ACTIVE;
    }

    public function draft()
    {
        if ($this->isDraft()) {
            throw new \DomainException('News is already draft.');
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
        return '{{%news}}';
    }

    public function behaviors()
    {
        return [

            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'photo',
                'createThumbsOnRequest' => true,
                'filePath' => '@photoRoot/uploads/origin/posts/[[id]].[[extension]]',
                'fileUrl' => '@host/uploads/origin/posts/[[id]].[[extension]]',
                'thumbPath' => '@photoRoot/uploads/cache/posts/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@host/uploads/cache/posts/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 640, 'height' => 480],
                    'news_list' => ['width' => 700, 'height' => 300],
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

    public static function find(): NewsQuery
    {
        return new NewsQuery(static::class);
    }
}