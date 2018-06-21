<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model core\entities\User */

$this->title = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('Users','/manager/user/index', ['id' => 'user-link'])?>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
