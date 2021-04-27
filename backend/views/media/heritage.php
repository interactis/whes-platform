<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Images');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Heritages'), 'url' => ['heritage/index']];
$this->params['breadcrumbs'][] = ['label' => $model->short_name, 'url' => ['heritage/update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="media-index">

    <h1><?= $model->name ?></h1>
    
    <?= Yii::$app->controller->renderPartial('//common/_navPills', ['model' => $model, 'active' => 2]) ?>

    <div class="row">
		<div class="col-md-10 col-lg-8">
    	
    	
    		<?= Html::a(Yii::t('app', 'Add Image'), ['create'], ['class' => 'btn btn-success']) ?>
    	</div>
    </div>
</div>
