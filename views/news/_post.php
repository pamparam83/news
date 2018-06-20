<?php

/* @var $this yii\web\View */
/* @var $model core\entities\News */

use yii\helpers\Html;
use yii\helpers\Url;

$url = Url::to(['item', 'id' =>$model->id]);
?>

<div class="row">
    <div class="col-md-7">
        <a href="<?= Html::encode($url) ?>">
            <img src="<?= Html::encode($model->getThumbFileUrl('photo', 'news_list')) ?>" alt=""
                 class="img-responsive"/>
        </a>
    </div>
    <div class="col-md-5">
        <div class="h2"><a href="<?= Html::encode($url) ?>"><?= Html::encode($model->title) ?></a></div>
        <p><?= Yii::$app->formatter->asNtext($model->description) ?></p>
    </div>
</div>
<hr>

