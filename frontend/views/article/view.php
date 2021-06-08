<?php

/* @var $this yii\web\View */

$this->title = $model->title;

if (isset($heritage))
	$this->params['breadcrumbs'][] = ['label' => $heritage->short_name, 'url' => ['/heritage/view', 'slug' => $heritage->slug]];

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">

	<?= Yii::$app->controller->renderPartial('//common/_jumbotron', ['models' => $content->media]) ?>

	<?= $this->render('_info.php', [
		'model' => $model,
		'content' => $content,
		'heritage' => $heritage
	]) ?>

</div>
