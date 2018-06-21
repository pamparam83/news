<?php

namespace core\services\manage\news;

use core\entities\News;
use core\forms\news\NewsEditForm;
use core\forms\news\NewsForm;
use core\helpers\NewsHelper;
use core\repositories\news\NewsRepository;
use core\repositories\UserRepository;
use yii\mail\MailerInterface;

class NewsManageService
{
    private $repository;  
    public $mailer;

    public $supportEmail;
    private $news;

    public function __construct(
        $supportEmail,
        UserRepository $repository,        
        MailerInterface $mailer,
        NewsRepository $news)    {

        $this->repository = $repository;        
        $this->mailer = $mailer;
        $this->supportEmail = $supportEmail;
        $this->news = $news;
    }

    public function create(NewsForm $form)
    {

        $news = News::create(
            $form->title,
            $form->description,
            $form->content
        );

        if ($form->photo) {
            $news->setPhoto($form->photo);
        }

        $news->on(News::EVENT_AFTER_INSERT,[$this,'emailNews'], $news);
        $this->news->save($news);

        return $news;
    }

    public function emailNews($event)
    {
        $news = $event->sender;
        $users = $this->repository->getByEmailAll();
        foreach ($users as $user) {
            $send = $this->mailer
                ->compose(
                    ['html' => 'events/news/confirm-html', 'text' => 'events/news/confirm-text'],
                    ['news' => $news, 'user' => $user]
                )
                ->setFrom($this->supportEmail)
                ->setTo($user->email)
                ->setSubject('Подтверждение Email на ' . \Yii::$app->name)
                ->send();

            if (!$send) {
                throw  new \RuntimeException('Ошибка: письмо не отправлено.');
            }
        }
    }
    public function edit($id, NewsEditForm $form)
    {
        $news = $this->news->get($id);

        $news->edit(
            $form->title,
            $form->description,
            $form->content
        );

        if ($form->photo) {
            $news->setPhoto($form->photo);
        }

        $this->news->save($news);
    }

    public function activate($id)
    {
        $news = $this->news->get($id);
        $news->activate();
        $this->news->save($news);
    }
    public function isAuthor($author)
    {
        return NewsHelper::isAuthor($author);
    }

    public function draft($id)
    {
        $news = $this->news->get($id);
        $news->draft();
        $this->news->save($news);
    }

    public function remove($id)
    {
        $news = $this->news->get($id);
        $this->news->remove($news);
    }
}