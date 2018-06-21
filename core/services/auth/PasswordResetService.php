<?php
namespace core\services\auth;

use core\repositories\UserRepository;
use core\forms\auth\PasswordResetRequestForm;
use core\entities\User;
use core\forms\auth\ResetPasswordForm;
use Yii;
use yii\mail\MailerInterface;
use yii\db\ActiveRecord;
class PasswordResetService
{

    public $supportEmail;
    /**
     * @var MailerInterface
     */
    public $mailer;

    public $users;

    /**
     * PasswordResetService constructor.
     * @param $supportEmail
     * @param UserRepository $users
     * @param MailerInterface $mailer
     */
    public function __construct($supportEmail,UserRepository $users, MailerInterface $mailer)
    {
        $this->supportEmail = $supportEmail;
        $this->mailer = $mailer;
        $this->users = $users;
    }

    /**
     * Sends an email with a link, for resetting the password.
     * @param PasswordResetRequestForm $form
     * @throws \yii\base\Exception
     */
    public function request(PasswordResetRequestForm $form)
    {
        /* @var $user User */
       $user = $this->users->getByEmail($form->email);

        if (!$user->isActive()) {
            throw new \DomainException('User is not fount');
        }

        $user->requestPasswordReset();
        $this->users->save($user);

        $send = $this->mailer
            ->compose(
                ['html' => 'auth/reset/confirm-html', 'text' => 'auth/reset/confirm-text'],
                ['user' => $user]
            )
            ->setFrom($this->supportEmail)
            ->setTo($user->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();

        if(!$send){
            throw  new \RuntimeException('Send: sanding error.');
        }
    }

    /**
     *  Validating Token
     * @param $token
     */
    public function validateToken($token)
    {
        if(empty($token) || !is_string($token)){
            throw new \DomainException('Password reset token cannot be blank.');
        }

        if (!$this->users->existsByPasswordResetToken($token)){
            throw new \DomainException('Wrong password reset token.');
        }
    }

   public function reset($token, ResetPasswordForm $form)
   {
        $user = $this->users->getByPasswordResetToken($token);
        $user->resetPassword($form->password);
        $this->users->save($user);

   }


    /**
     * @param User $user
     * @param $form
     * @return bool
     * @throws \yii\base\Exception
     */
    public function changePassword(User $user, $form)
    {
            $user->setPassword($form->newPassword);

            $user->on(ActiveRecord::EVENT_AFTER_UPDATE,[$this,'emailResetPassword'],$user);
            return $user->save();
    }

    public function emailResetPassword($event)
    {
        $user = $event->sender;

        $send = $this->mailer
            ->compose(
                ['html' => 'events/reset/confirm-html', 'text' => 'events/reset/confirm-text'],
                ['user' => $user]
            )
            ->setFrom($this->supportEmail)
            ->setTo($user->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();

        if(!$send){
            throw  new \RuntimeException('Send: sanding error.');
        }
    }
}