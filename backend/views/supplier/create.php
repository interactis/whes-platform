<?php
use yii\helpers\Html;

$type = $content->types[$content->type];
$contentModel = $content->{$type};

$this->title = Yii::t('app', 'Supplier');
$this->params['breadcrumbs'][] = ['label' => $contentModel->pluralName(), 'url' => [$type .'/index']];
$this->params['breadcrumbs'][] = ['label' => $contentModel->title, 'url' => [$type .'/update', 'id' => $contentModel->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-update">

    <h1><?= $contentModel->title ?></h1>
    
    <?= $this->render('/common/_contentNavPills', [
    	'model' => $content,
    	'active' => 'supplier',
    	'showSupplier' => true
    ]) ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
