<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Heritage */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Heritages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->short_name;
?>
<div class="heritage-update">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= Yii::$app->controller->renderPartial('//common/_navPills', ['model' => $model, 'active' => 1]) ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
