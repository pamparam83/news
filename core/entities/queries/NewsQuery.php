<?php

namespace core\entities\queries;

use core\entities\News;
use yii\db\ActiveQuery;

class NewsQuery extends ActiveQuery
{
    /**
     * @param null $alias
     * @return $this
     */
    public function active($alias = null)
    {
        return $this->andWhere([
            ($alias ? $alias . '.' : '') . 'status' => News::STATUS_ACTIVE,
        ]);
    }
}