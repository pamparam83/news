<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $user core\entities\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('Users','/user/index', ['id' => 'user-link'])?>|
    <?= Html::a('view',['/user/view','id' => $model->id], ['id' => 'user-view', 'data-key' => $model->id])?>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id],
            [
            'class' => 'btn btn-primary',
            'aria-label' => 'Update',
            'data-key' => $model->id
        ]) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'email:email',
            'status',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
