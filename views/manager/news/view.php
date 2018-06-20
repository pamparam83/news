<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use \core\helpers\NewsHelper;
/* @var $this yii\web\View */
/* @var $model core\entities\News */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if(NewsHelper::isAuthor($model->author)):?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php endif;?>
    </p>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'status',
                        'value' =>NewsHelper::statusLabel($model->status),
                        'format' => 'raw',
                    ],
                    'title',
                    'description:ntext',
                    'content:ntext',

                ],
            ]) ?>

            <?php if ($model->photo): ?>
                <?= Html::a(Html::img($model->getThumbFileUrl('photo', 'thumb')), $model->getUploadedFileUrl('photo'), [
                    'class' => 'thumbnail',
                    'target' => '_blank'
                ]) ?>
            <?php endif; ?>


</div>
