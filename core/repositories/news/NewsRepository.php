<?php

namespace core\repositories\news;

use core\entities\News;

class NewsRepository
{
    /**
     * @param $id
     * @return News|null
     */
    public function get($id)
    {
        if (!$news = News::findOne($id)) {
            throw new \DomainException('News is not found.');
        }
        return $news;
    }

    public function save(News $news)
    {
        if (!$news->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(News $news)
    {
        if (!$news->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}