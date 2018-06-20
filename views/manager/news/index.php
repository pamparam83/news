<?php

use yii\helpers\Html;
use yii\grid\GridView;
use core\entities\News;
use core\helpers\NewsHelper;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'News';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create News', ['create'], ['class' => 'btn btn-success create',
//            'id' => 'modal',
            'data-toggle' => 'modal',
            'data-target' => '#modal',
        ]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'value' => function (News $model) {
                    return $model->photo ? Html::img($model->getThumbFileUrl('photo', 'admin')) : null;
                },
                'label' => 'Photo',
                'format' => 'raw',
                'contentOptions' => ['style' => 'width: 100px'],
            ],
            [
                'attribute' => 'created_at',
                'label' => 'Create',
                'format' => 'datetime',
            ],
            [
                'attribute' => 'title',
                'value' => function (News $model) {
                    return Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'description',
                'value' => function (News $model) {
                    return Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'status',
                'filter' => $searchModel->statusList(),
                'value' => function (News $model) {
                    return NewsHelper::statusLabel($model->status);
                },
                'format' => 'raw',
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
<?php Modal::begin([
    'id' => 'modal',
    'header' => '<h2>Hello world</h2>',
//    'toggleButton' => ['label' => 'click me'],
//    'footer' => 'Низ окна',
]);
echo '<div class="modal-content"></div>';
Modal::end();
?>