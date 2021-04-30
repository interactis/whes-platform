<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-create">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= Yii::$app->controller->renderPartial('//common/_contentNavPills', [
    	'model' => $model->content,
    	'active' => 1
    ]) ?>

    <?= $this->render('_form', [
        'model' => $model,
        'contentModel' => $contentModel,
    ]) ?>

</div>
