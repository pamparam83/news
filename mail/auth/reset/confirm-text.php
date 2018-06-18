<?php

/* @var $this yii\web\View */
/* @var $user \core\entities\User\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['auth/reset/confirm', 'token' => $user->password_reset_token]);
?>
Привет <?= $user->username ?>,

Для подтверждения email пройдите по ссылке:

<?= $resetLink ?>
