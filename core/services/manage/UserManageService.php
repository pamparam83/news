<?php

namespace core\services\manage;

use core\entities\User;
use core\forms\User\UserCreateForm;
use core\forms\User\UserEditForm;
use core\repositories\UserRepository;
use core\services\RoleManager;
use core\services\TransactionManager;
use yii\mail\MailerInterface;
use yii\db\ActiveRecord;
class UserManageService
{
    private $repository;
    private $roles;
    private $transaction;
    public $mailer;

    public $supportEmail;

    /**
     * UserManageService constructor.
     * @param UserRepository $repository
     * @param RoleManager $roles
     * @param TransactionManager $transaction
     * @param MailerInterface $mailer
     * @param $supportEmail
     */
    public function __construct($supportEmail,
        UserRepository $repository,
        RoleManager $roles,
        TransactionManager $transaction,
        MailerInterface $mailer

    )
    {
        $this->repository = $repository;
        $this->roles = $roles;
        $this->transaction = $transaction;
         $this->mailer = $mailer;
        $this->supportEmail = $supportEmail;
    }

    /**
     * @param UserCreateForm $form
     * @return User
     * @throws \yii\base\Exception
     */
    public function create(UserCreateForm $form)
    {
        $user = User::requestSignup(
            $form->username,
            $form->email,
            $form->password
                   );

        $user->on(ActiveRecord::EVENT_AFTER_INSERT,[$this,'emailSignUp'],[$user,'password' => $form->password]);

        $this->transaction->wrap(function () use ($user, $form) {
            $this->repository->save($user);
            $this->roles->assign($user->id, $form->role);
        });
        $this->repository->save($user);
        return $user;
    }

    public function emailSignUp($event)
    {
        $user = $event->sender;
        $send = $this->mailer
            ->compose(
                ['html' => 'events/signup/confirm-html', 'text' => 'events/signup/confirm-text'],
                ['user' => $user,
                  'password' => $event->data['password']]
            )
            ->setFrom($this->supportEmail)
            ->setTo($user->email)
            ->setSubject('Подтверждение Email на ' . \Yii::$app->name)
            ->send();

        if(!$send){
            throw  new \RuntimeException('Ошибка: письмо не отправлено.');
        }

    }

    /**
     * @param $id
     * @param UserEditForm $form
     * @throws \Exception
     */
    public function edit($id, UserEditForm $form)
    {
        $user = $this->repository->get($id);
        $user->edit(
            $form->username,
            $form->email
        );
        $this->transaction->wrap(function () use ($user, $form) {
            $this->repository->save($user);
            $this->roles->assign($user->id, $form->role);
        });
        $this->repository->save($user);
    }

    public function assignRole($id, $role)
    {
        $user = $this->repository->get($id);
        $this->roles->assign($user->id, $role);
    }

    public function remove($id)
    {
        $user = $this->repository->get($id);
        $this->repository->remove($user);
    }
}