<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \core\forms\auth\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Sign Up';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title);?></h1>
<p>if you are authorized, please go <a href="/auth/login">Login</a>.</p>
<?php $form = ActiveForm::begin([
    'id' => 'form-signup',
    'fieldConfig' => [
        'template' => "{label}\n{beginWrapper}\n<div class=\"col-sm-10\">{input}</div>\n{hint}\n{error}\n{endWrapper}",
        'labelOptions' => ['class' => 'col-sm-4 control-label'],
    ],
]); ?>
<fieldset id="account">
    <?= $form->field($model, 'username')->textInput(['autofocus' => true,'placeholder' => 'Login']) ?>
    <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email']) ?>
</fieldset>
<fieldset>
    <legend>You password</legend>
    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password']) ?>
    <?= $form->field($model, 'passwordConfirm')->passwordInput(['placeholder' => 'password confirm']) ?>
</fieldset>

<div class="buttons">
    <div class="pull-right">
        <?= Html::submitButton('Enter', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>




