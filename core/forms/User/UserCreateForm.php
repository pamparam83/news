<?php

namespace core\forms\User;

use core\entities\User;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class UserCreateForm extends Model
{
    public $username;
    public $email;
    public $id;
    public $password;
    public $passwordConfirm;
    public $role;

    public function rules()
    {
        return [
            [['username', 'email','passwordConfirm'], 'required'],
            ['email', 'email'],
            [['username','email'], 'string', 'max' => 255],
            ['role', 'string', 'max' => 20],
            ['role','default','value' => 'User'],
            [['username', 'email'], 'unique', 'targetClass' => User::class],
            ['password', 'string', 'min' => 6],

            [['password','passwordConfirm'], 'string', 'min' => 6],
            [ ['passwordConfirm'], 'compare', 'compareAttribute' => 'password', 'message'=>'Пароли не совпадают'],
        ];
    }



    public function rolesList()
    {
        return ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description');
    }
}