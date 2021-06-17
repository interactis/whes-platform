<?php
use yii\helpers\Html;

$this->title = Yii::t('app', 'Edited Content');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="quality-control-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <div class="row">
    	<div class="col-md-8">
    		<p class="lead hint-block margin-bottom">Content that has been edited by the heritages is still displayed in the frontend view. Please check if everything is still ok.</p>
		</div>
	</div>
	
    <?= $this->render('_index', ['dataProvider' => $dataProvider]) ?>

</div>
