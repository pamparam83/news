<?php

/* @var $this yii\web\View */
/* @var $news core\entities\News */

use yii\helpers\Html;

$this->title = $news->title;

$this->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['index']];
$this->params['breadcrumbs'][] = $news->title;



?>

<article>
    <h1><?= Html::encode($news->title) ?></h1>

    <p><span class="glyphicon glyphicon-calendar"></span> <?= \Yii::$app->formatter->asDatetime($news->created_at); ?></p>

        <p><img src="<?= Html::encode($news->getThumbFileUrl('photo', 'thumb','/images/not-photo.png')) ?>" alt="" class="img-responsive" /></p>

    <?= Yii::$app->formatter->asHtml($news->content, [
        'Attr.AllowedRel' => array('nofollow'),
        'HTML.SafeObject' => true,
        'Output.FlashCompat' => true,
        'HTML.SafeIframe' => true,
        'URI.SafeIframeRegexp'=>'%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
    ]) ?>
</article>




