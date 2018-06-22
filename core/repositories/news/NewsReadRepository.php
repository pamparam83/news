<?php

namespace core\repositories\news;

use core\entities\News;
use yii\data\ActiveDataProvider;

use yii\db\ActiveQuery;

class NewsReadRepository
{
    public function count()
    {
        return News::find()->active()->count();
    }

    public function getAllByRange($offset, $limit)
    {
        return News::find()->active()->orderBy(['id' => SORT_ASC])->limit($limit)->offset($offset)->all();
    }

    public function getAll()
    {
        $query = News::find()->active();
        return $this->getProvider($query);
    }

    public function getLast($limit)
    {
        return News::find()->with('category')->orderBy(['id' => SORT_DESC])->limit($limit)->all();
    }

    public function getPopular($limit)
    {
        return News::find()->with('category')->orderBy(['comments_count' => SORT_DESC])->limit($limit)->all();
    }

    public function find($id)
    {
        return News::find()->active()->andWhere(['id' => $id])->one();
    }

    private function getProvider(ActiveQuery $query)
    {
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
            'pagination' => [
                'pageSizeLimit' => 5,
            ],
        ]);
    }
}