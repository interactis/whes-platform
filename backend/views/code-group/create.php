<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CodeGroup */

$this->title = Yii::t('app', 'Create Code Group');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Code Series'), 'url' => ['code-series/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Code Series') .' #'. $codeSeries->id, 'url' => ['code/index', 'id' => $codeSeries->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="code-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
