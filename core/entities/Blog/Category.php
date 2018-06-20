<?php

namespace core\entities\Blog;

use core\entities\behaviors\MetaBehavior;
use core\entities\Meta;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property int $sort
 * @property Meta $meta
 */
class Category extends ActiveRecord
{
    public $meta;

    public static function create($name, $slug, $title, $description, $sort, Meta $meta)
    {
        $category = new static();
        $category->name = $name;
        $category->slug = $slug;
        $category->title = $title;
        $category->description = $description;
        $category->sort = $sort;
        $category->meta = $meta;
        return $category;
    }

    public function edit($name, $slug, $title, $description, $sort, Meta $meta)
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->title = $title;
        $this->description = $description;
        $this->sort = $sort;
        $this->meta = $meta;
    }


//    public function attributeLabels()
//    {
//        return [
//            'name' => 'Название',
//            'slug' => 'Слуг',
//            'sort' => 'Сортировка',
//            'parentId' => 'Категория',
//            'title' => 'Заголовок',
//            'description' => 'Описание',
//        ];
//    }

    public function getSeoTitle()
    {
        return $this->meta->title ?: $this->getHeadingTile();
    }

    public function getHeadingTile()
    {
        return $this->title ?: $this->name;
    }

    public static function tableName()
    {
        return '{{%blog_categories}}';
    }

    public function behaviors()
    {
        return [
            MetaBehavior::className(),
        ];
    }
}