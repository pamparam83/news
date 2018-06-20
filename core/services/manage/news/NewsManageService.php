<?php

namespace core\services\manage\news;

use core\entities\News;
use core\forms\news\NewsEditForm;
use core\forms\news\NewsForm;
use core\helpers\NewsHelper;
use core\repositories\news\NewsRepository;

class NewsManageService
{
    private $posts;

    public function __construct(NewsRepository $posts)    {
        $this->posts = $posts;
    }

    public function create(NewsForm $form)
    {

        $post = News::create(
            $form->title,
            $form->description,
            $form->content
        );

        if ($form->photo) {
            $post->setPhoto($form->photo);
        }


        $this->posts->save($post);

        return $post;
    }

    public function edit($id, NewsEditForm $form)
    {
        $post = $this->posts->get($id);

        $post->edit(
            $form->title,
            $form->description,
            $form->content
        );

        if ($form->photo) {
            $post->setPhoto($form->photo);
        }

        $this->posts->save($post);
    }

    public function activate($id)
    {
        $post = $this->posts->get($id);
        $post->activate();
        $this->posts->save($post);
    }
    public function isAuthor($author)
    {
        return NewsHelper::isAuthor($author);
    }

    public function draft($id)
    {
        $post = $this->posts->get($id);
        $post->draft();
        $this->posts->save($post);
    }

    public function remove($id)
    {
        $post = $this->posts->get($id);
        $this->posts->remove($post);
    }
}