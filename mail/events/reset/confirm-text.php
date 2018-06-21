<?php

/* @var $this yii\web\View */
/* @var $user \core\entities\User */
$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['/cabinet/default/password']);
?>
Привет, <?= $user->username ?>,

На сате: <?php echo Yii::$app->name;?>, в личном кабинете был изменен пароль
Для подтверждения этого действия пройдите по ссылке.

<?= $confirmLink ?>
