<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \core\forms\auth\SignupForm */

use yii\helpers\Html;
use kartik\form\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title);?></h1>
<p>Если Вы уже зарегистрированы, перейдите на страницу <a href="/login">авторизации</a>.</p>
<?php $form = ActiveForm::begin([
    'id' => 'form-signup',
    'fieldConfig' => [
        'template' => "{label}\n{beginWrapper}\n<div class=\"col-sm-10\">{input}</div>\n{hint}\n{error}\n{endWrapper}",
        'labelOptions' => ['class' => 'col-sm-4 control-label'],
        'horizontalCssClasses' => [
            'offset' => 'col-sm-offset-4',
            'wrapper' => 'col-sm-8',
            'error' => '',
            'hint' => '',
        ],
    ],
]); ?>
<fieldset id="account">
    <legend>Заполните форму</legend>
    <div class="form-group required" style="display:  none ;">
        <label class="col-sm-2 control-label">Категория</label>
        <div class="col-sm-10">
            <div class="radio">
                <label>
                    <input type="radio" name="customer_group_id" value="1" checked="checked" />
                    Физ.лицо</label>
            </div>
        </div>
    </div>
    <?= $form->field($model, 'username')->textInput(['autofocus' => true,'placeholder' => 'Введите логин']) ?>

    <?= $form->field($model, 'last_name')->textInput(['placeholder' => 'Введите фамилию']) ?>
    <?= $form->field($model, 'first_name')->textInput(['placeholder' => 'Введите имя']) ?>

    <?= $form->field($model, 'email')->textInput(['placeholder' => 'Введите Email']) ?>
    <?= $form->field($model, 'phone', ['addon' => ['prepend' => ['content'=>'+7']]]) ?>

</fieldset>
<fieldset>
    <legend>Ваш пароль</legend>
    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Введите пароль']) ?>
    <?= $form->field($model, 'passwordConfirm')->passwordInput(['placeholder' => 'Подтверждение пароля']) ?>
</fieldset>
<fieldset>
    <legend>Рассылка новостей</legend>
    <div class="form-group">
        <label class="col-sm-2 control-label">Подписка на новости.</label>
        <div class="col-sm-10">               <label class="radio-inline">
                <input type="radio" name="newsletter" value="1" />
                Да</label>
            <label class="radio-inline">
                <input type="radio" name="newsletter" value="0" checked="checked" />
                Нет</label>
        </div>
    </div>
</fieldset>

<div class="buttons">
    <div class="pull-right">Я прочитал и согласен с <a href="/index.php?route=information/information/agree&amp;information_id=3" class="agree"><b>Политикой конфиденциальности</b></a>
        <input type="checkbox" name="agree" value="1" />
        &nbsp;
        <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
<script><!--
    // Sort the custom fields
    $('#account .form-group[data-sort]').detach().each(function() {
        if ($(this).attr('data-sort') >= 0 && $(this).attr('data-sort') <= $('#account .form-group').length) {
            $('#account .form-group').eq($(this).attr('data-sort')).before(this);
        }

        if ($(this).attr('data-sort') > $('#account .form-group').length) {
            $('#account .form-group:last').after(this);
        }

        if ($(this).attr('data-sort') == $('#account .form-group').length) {
            $('#account .form-group:last').after(this);
        }

        if ($(this).attr('data-sort') < -$('#account .form-group').length) {
            $('#account .form-group:first').before(this);
        }
    });

    // $('input[name=\'customer_group_id\']').on('change', function() {
    //     $.ajax({
    //         url: 'index.php?route=account/register/customfield&customer_group_id=' + this.value,
    //         dataType: 'json',
    //         success: function(json) {
    //             $('.custom-field').hide();
    //             $('.custom-field').removeClass('required');
    //
    //             for (i = 0; i < json.length; i++) {
    //                 custom_field = json[i];
    //
    //                 $('#custom-field' + custom_field['custom_field_id']).show();
    //
    //                 if (custom_field['required']) {
    //                     $('#custom-field' + custom_field['custom_field_id']).addClass('required');
    //                 }
    //             }
    //         },
    //         error: function(xhr, ajaxOptions, thrownError) {
    //             alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    //         }
    //     });
    // });

    $('input[name=\'customer_group_id\']:checked').trigger('change');
    //--></script>
<script><!--
    $('button[id^=\'button-custom-field\']').on('click', function() {
        var element = this;

        $('#form-upload').remove();

        $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

        $('#form-upload input[name=\'file\']').trigger('click');

        if (typeof timer != 'undefined') {
            clearInterval(timer);
        }

        timer = setInterval(function() {
            if ($('#form-upload input[name=\'file\']').val() != '') {
                clearInterval(timer);

                $.ajax({
                    url: 'index.php?route=tool/upload',
                    type: 'post',
                    dataType: 'json',
                    data: new FormData($('#form-upload')[0]),
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $(element).button('loading');
                    },
                    complete: function() {
                        $(element).button('reset');
                    },
                    success: function(json) {
                        $(element).parent().find('.text-danger').remove();

                        if (json['error']) {
                            $(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
                        }

                        if (json['success']) {
                            alert(json['success']);

                            $(element).parent().find('input').val(json['code']);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        }, 500);
    });
    //--></script>



