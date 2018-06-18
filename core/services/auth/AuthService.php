<?php
namespace core\services\auth;

use core\forms\auth\LoginForm;
use core\repositories\UserRepository;
class AuthService
{
    private $users;
    
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * @param LoginForm $form
     * @return array|null|\yii\db\ActiveRecord
     */
    public function auth(LoginForm $form)
    {
        $user = $this->users->findByUsernameOrEmail($form->username);
        if(!$user || !$user->isActive() || !$user->validatePassword($form->password)){
            throw new \DomainException('Не верный логин или пароль.');
        }
        
        return $user;
    }
}