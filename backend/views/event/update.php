<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Event */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-create">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= $this->render('/common/_contentNavPills', [
    	'model' => $model->content,
    	'active' => 'info',
    	'showSupplier' => true
    ]) ?>

    <?= $this->render('_form', [
        'model' => $model,
        'contentModel' => $contentModel,
    ]) ?>

</div>
