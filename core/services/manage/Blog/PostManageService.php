<?php

namespace core\services\manage\Blog;

use core\entities\Blog\Post;
use core\forms\manage\Blog\Post\PostForm;
use core\repositories\Blog\PostRepository;

class PostManageService
{
    private $posts;

    public function __construct(PostRepository $posts)    {
        $this->posts = $posts;
    }

    public function create(PostForm $form)
    {

        $post = Post::create(
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

    public function edit($id, PostForm $form)
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