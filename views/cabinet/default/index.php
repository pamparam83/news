<?php
use yii\helpers\Html;
use \yii\widgets\DetailView;

$this->title = 'Private info';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cabinet-index">
    <h1><?php echo Html::encode($this->title); ?></h1>
<p>
    <?= Html::a('Reset password',\yii\helpers\Url::to('/cabinet/password'))?>
</p>
    <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
               'username',
                'email:email',
                'created_at:datetime',
            ],
    ])?>

</div>
