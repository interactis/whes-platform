<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FlagGroup */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Flag Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flag-group-update">

    <h1><?= Html::encode($this->title) ?></h1>
	
	<?= Yii::$app->controller->renderPartial('//common/_flagNavPills', [
    	'model' => $model,
    	'active' => 1
    ]) ?>
	
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
