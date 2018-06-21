<?php

namespace core\services\auth;

use core\access\Rbac;
use core\entities\User;
use core\forms\auth\SignupForm;
use core\repositories\UserRepository;
use core\services\RoleManager;
use core\services\TransactionManager;
use Yii;
use yii\mail\MailerInterface;

class SignupService
{
    private $users;
    private $roles;
    private $transaction;
    private $mailer;

    public function __construct(
        $supportEmail,
        UserRepository $users,
        RoleManager $roles,
        TransactionManager $transaction,
        MailerInterface $mailer
    )
    {
        $this->users = $users;
        $this->supportEmail = $supportEmail;
        $this->roles = $roles;
        $this->transaction = $transaction;
        $this->mailer = $mailer;
    }

    /**
     * @param SignupForm $form
     * @throws \Exception
     */
    public function signup(SignupForm $form)
    {
        $user = User::requestSignup(
            $form->username,
            $form->email,
            $form->password
        );
        $this->transaction->wrap(function () use ($user) {
            $this->users->save($user);
            $this->roles->assign($user->id, Rbac::ROLE_USER);
        });
        $send = $this->mailer
            ->compose(
                ['html' => 'auth/signup/confirm-html', 'text' => 'auth/signup/confirm-text'],
                ['user' => $user]
            )
            ->setFrom($this->supportEmail)
            ->setTo($user->email)
            ->setSubject('Подтверждение Email на ' . Yii::$app->name)
            ->send();

        if(!$send){
            throw  new \RuntimeException('Ошибка: письмо не отправлено.');
        }
    }

    /**
     * @param $token
     */
    public function confirm($token)
    {
        if (empty($token)) {
            throw new \DomainException('Такого токена не существует.');
        }
        $user = $this->users->getByEmailConfirmToken($token);
        $user->confirmSignup();
        $this->users->save($user);
    }


}