<?php
use yii\helpers\Html;

$heritage = $model->heritage;

$this->title = Yii::t('app', 'Update Image');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Heritages'), 'url' => ['heritage/index']];
$this->params['breadcrumbs'][] = ['label' => $heritage->short_name, 'url' => ['heritage/update', 'id' => $heritage->id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Images'), 'url' => ['media/heritage', 'id' => $heritage->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="media-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
