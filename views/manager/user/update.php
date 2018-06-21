<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user core\entities\User */

$this->title = 'Update User: ' . $user->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->id, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('Users','/user/index', ['id' => 'user-link'])?>|
    <?= Html::a('view',['/user/view','id' => $user->id], ['id' => 'user-view', 'data-key' => $user->id])?>

    <?= $this->render('_form', [
        'model' => $model,
        'user' => $user,
    ]) ?>

</div>
