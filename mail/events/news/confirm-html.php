<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \core\entities\User */
/* @var $news \core\entities\News */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['/news/item', 'id' => $news->id]);
?>
<div class="password-reset">
    <p>Привет, <?= Html::encode($user->username) ?>!!!</p>
    <p>На сате: <?php echo Yii::$app->name;?>, есть новая статья</br>

    </p>

    <p><?= Html::a(Html::encode($news->title), $confirmLink) ?></p>
</div>
