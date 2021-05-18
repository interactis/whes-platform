<?php

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Our Heritage');
?>
<div class="site-index">

	<?= Yii::$app->controller->renderPartial('//common/_jumbotron', ['models' => $media]) ?>

	<?= $this->render('_intro.php', [
		'model' => $model
	]) ?>
    
</div>
