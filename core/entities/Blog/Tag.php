<?php

namespace core\entities\Blog;

use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $name
 * @property string $slug
 */
class Tag extends ActiveRecord
{
    public static function create($name, $slug)
    {
        $tag = new static();
        $tag->name = $name;
        $tag->slug = $slug;
        return $tag;
    }

    public function edit($name, $slug)
    {
        $this->name = $name;
        $this->slug = $slug;
    }

    public static function tableName()
    {
        return '{{%blog_tags}}';
    }


    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'slug' => 'Слуг',
        ];
    }


}