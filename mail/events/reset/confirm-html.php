<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \core\entities\User */
$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['/cabinet/default/password']);
?>
<div class="password-reset">
    <p>Привет, <?= Html::encode($user->username) ?>!!!</p>
    <p>На сате: <?php echo Yii::$app->name;?>, в личном кабинете был изменен пароль</br>
    Для подтверждения этого действия пройдите по ссылке.
    </p>

    <p><?= Html::a(Html::encode('Подтвердить свой Email.'), $confirmLink) ?></p>
</div>
