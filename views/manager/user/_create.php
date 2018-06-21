<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model core\entities\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'id')->hiddenInput(['value'=>$model->id])->label(false); ?>
    <legend>Password</legend>
    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password']) ?>
    <?= $form->field($model, 'passwordConfirm')->passwordInput(['placeholder' => 'password confirm']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', [
            'class' => 'btn btn-success',
            'id' => 'user-save',

        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
