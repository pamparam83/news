<?php

/* @var $this yii\web\View */
/* @var $user \core\entities\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['signup/confirm', 'token' => $user->email_confirm_token]);
?>
Привет, <?= $user->username ?>,

Ваш Email был зарегестрирован на сате: <?php echo Yii::$app->name;?>,
Для подтверждения email пройдите по ссылке.
Ваш временный пароль <?= $password;?>
<?= $confirmLink ?>
