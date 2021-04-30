<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Poi */

$this->title = Yii::t('app', 'Create Point of Interest');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Points of Interest'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="poi-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'contentModel' => $contentModel,
    ]) ?>

</div>
