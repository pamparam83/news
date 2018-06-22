<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\DataProviderInterface */

?>
<div class="limit">
    <div class="input-group">
        <label class="input-group-addon" for="input-limit">Показать:</label>
        <select id="input-limit" class="form-control" onchange="location = this.value;">
            <?php
            $values = ['',2, 5, 10, 75, 100];
            $current = $dataProvider->getPagination()->getPageSize();
            ?>
            <?php foreach ($values as $value): ?>
                <option value="<?= Html::encode(Url::current(['per-page' => $value])) ?>" <?php if ($current == $value): ?>selected="selected"<?php endif; ?>><?= $value ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<br><br>
<?php foreach ($dataProvider->getModels() as $post): ?>
    <?= $this->render('_post', [
        'model' => $post
    ]) ?>
<?php endforeach; ?>

<div class="pagination-result">
    <div class="pull-right">
        <?= LinkPager::widget([
            'pagination' => $dataProvider->getPagination(),
        ]) ?>
    </div>
</div>

