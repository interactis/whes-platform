<?php
use yii\helpers\Html;

$this->title = Yii::t('app', 'Unapproved Content');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="quality-control-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <div class="row">
    	<div class="col-md-10 col-lg-7">
    		<p class="lead hint-block margin-bottom">Content created by the heritages is not automatically displayed in the frontend view. Please check if everything is ok and approve it.</p>
		</div>
	</div>

    <?= $this->render('_index', ['dataProvider' => $dataProvider]) ?>

</div>
