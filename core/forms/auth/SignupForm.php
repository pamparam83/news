<?php
namespace core\forms\auth;

use yii\base\Model;
use core\entities\User;
/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $passwordConfirm;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username','email','password'], 'trim'],
            [['username','email','password','passwordConfirm'], 'required'],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'Это имя пользователя уже существует.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'Этот адрес электронной почты уже существует. Пожалуйста авторизуйтесь.'],

            [['password','passwordConfirm'], 'string', 'min' => 6],
            [ ['passwordConfirm'], 'compare', 'compareAttribute' => 'password', 'message'=>'Пароли не совпадают'],


        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'email' => 'Email',
            'password' => 'Пароль',
            'passwordConfirm' => 'Подтверждение пароля',
        ];
    }

}
