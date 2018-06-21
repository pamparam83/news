<?php
namespace core\entities;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $email_confirm_token
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $last_auth
 * @property string $password write-only password
 *
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_WAIT = 0;
    const STATUS_ACTIVE = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }
    public function attributeLabels()
    {
        return [
            'username' => 'username',
            'email' => 'email',
            'password' => 'password',
            'status' => 'status',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
            'last_auth' => 'LastAuth',
        ];
    }

    /**
     * @param $username
     * @param $email
     * @param $password
     * @return User
     * @throws \yii\base\Exception
     */
    public static function create($username,$email, $password)
    {
        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->last_auth = time();
        $user->setPassword(!empty($password) ? $password : Yii::$app->security->generateRandomString());
        $user->created_at = time();
        $user->status = self::STATUS_ACTIVE;
        $user->auth_key = Yii::$app->security->generateRandomString();
        return $user;
    }

    public function edit($username,$email)
    {
        $this->username = $username;
        $this->email = $email;
        $this->updated_at = time();
    }


    /**
     * @param $username
     * @param $email
     * @param $password
     * @return User
     * @throws \yii\base\Exception
     */
    public static function requestSignup($username,$email,$password)
    {
        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->setPassword($password);
        $user->last_auth = time();
        $user->status = self::STATUS_WAIT;
        $user->generateEmailConfirmToken();
        $user->generateAuthKey();
        return $user;
    }


    public function confirmSignup()
    {
        if(!$this->isWait())
        {
            throw new \DomainException('Пользователь не активирован.');
        }
        $this->status = self::STATUS_ACTIVE;
        $this->removeEmailConfirmToken();
    }

    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isWait()
    {
        return $this->status === self::STATUS_WAIT;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }



    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @param $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @throws \yii\base\Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }


    /**
     * @throws \yii\base\Exception
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }


    /**
     * @throws \yii\base\Exception
     */
    public function requestPasswordReset()
    {
        if(!empty($this->password_reset_token) && self::isPasswordResetTokenValid($this->password_reset_token)){
            throw new \DomainException('Password resetting is already requested.');
        }
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }


    /**
     * @param $password
     * @throws \yii\base\Exception
     */
    public function resetPassword($password){
        if(empty($this->password_reset_token)){
            throw new \DomainException('Password resetting is not requested.');
        }
        $this->setPassword($password);
        $this->password_reset_token = null;
    }


    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @throws \yii\base\Exception
     */
    private function generateEmailConfirmToken()
    {
        $this->email_confirm_token = Yii::$app->security->generateRandomString();
    }

    private function removeEmailConfirmToken()
    {
        $this->email_confirm_token = null;
    }
}
