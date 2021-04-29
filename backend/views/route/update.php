<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Route */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Routes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="route-create">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= Yii::$app->controller->renderPartial('//common/_navPills', [
    	'model' => $model->content,
    	'active' => 1,
    	'showSupplier' => true
    ]) ?>

    <?= $this->render('_form', [
        'model' => $model,
        'contentModel' => $contentModel,
    ]) ?>

</div>
