<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CodeGroup */

$this->title = Yii::t('app', 'Update Code Group: {name}', [
    'name' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Code Series'), 'url' => ['code-series/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Code Series') .' #'. $codeSeries->id, 'url' => ['code/index', 'id' => $codeSeries->id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Code Groups'), 'url' => ['code-group/index', 'id' => $codeSeries->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="code-group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
         'showCodeCount' => false,
    ]) ?>

</div>
