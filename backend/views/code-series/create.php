<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CodeSeries */

$this->title = Yii::t('app', 'Create Code Series');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Code Series'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="code-series-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
