<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \core\entities\User\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['signup/confirm', 'token' => $user->email_confirm_token]);
?>
<div class="password-reset">
    <p>Привет, <?= Html::encode($user->username) ?>!!!</p>

    <p>Ваш Email был зарегестрирован на сате: <?php echo Yii::$app->name;?> </br>Для подтверждения email пройдите по ссылке.</p>

    <p><?= Html::a(Html::encode('Подтвердить свой Email.'), $confirmLink) ?></p>
</div>
