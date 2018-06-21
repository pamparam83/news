<?php

/* @var $this yii\web\View */
/* @var $user \core\entities\User */
/* @var $news \core\entities\News */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['/news/item', 'id' => $news->id]);
?>
Привет, <?= $user->username ?>,

На сате: <?php echo Yii::$app->name;?>, есть новая статья.

<?= $confirmLink ?>
