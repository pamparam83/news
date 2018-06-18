<?php
namespace core\repositories;

use core\entities\User;
class UserRepository
{

    public function findByUsernameOrEmail($value)
    {
        return User::find()->andWhere(['or', ['username' => $value], ['email' => $value]])->one();
    }
    public function findByNetworkIdentity($network, $identity)
    {
        return User::find()->joinWith('networks n')->andWhere(['n.network' => $network, 'n.identity' => $identity])->one();
    }
    public function getByEmailConfirmToken($token)
    {
        return $this->getBy(['email_confirm_token' => $token]);
    }

    public function existsByPasswordResetToken($token)
    {
        return User::findByPasswordResetToken($token);
    }

    public function getByPasswordResetToken($token)
    {
        return $this->getBy(['password_reset_token' => $token]);
    }

    public function getByEmail($email)
    {
        return $this->getBy(['email' => $email]);
    }


    public function save(User $user)
    {
        if(!$user->save()){
            throw new \RuntimeException('Saving error');
        }
    }

    public function get($id)
    {
        return $this->getBy(['id' => $id]);
    }

    public function getBy(array $condition)
    {
        if(!$user = User::find()->andWhere($condition)->limit(1)->one()){
            throw new \DomainException('User is not fount');
        }
        return $user;
    }
    public function remove(User $user)
    {
        if (!$user->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}