<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Poi */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Points of Interest'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="poi-create">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= $this->render('/common/_contentNavPills', [
    	'model' => $model->content,
    	'active' => 1,
    	'showSupplier' => true
    ]) ?>

    <?= $this->render('_form', [
        'model' => $model,
        'contentModel' => $contentModel,
    ]) ?>

</div>
