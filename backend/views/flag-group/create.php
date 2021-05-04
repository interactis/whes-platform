<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FlagGroup */

$this->title = Yii::t('app', 'Create Flag Group');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Flag Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flag-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
