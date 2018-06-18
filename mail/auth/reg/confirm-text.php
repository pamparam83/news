<?php

/* @var $this yii\web\View */
/* @var $user \core\entities\User\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/signup/confirm', 'token' => $user->email_confirm_token]);
?>
Привет, <?= $user->username ?>,

Ваш Email был зарегестрирован на сате: <?php echo Yii::$app->name;?>,
Для подтверждения email пройдите по ссылке.

<?= $confirmLink ?>
Ваш пароль <?= $password; ?>.
