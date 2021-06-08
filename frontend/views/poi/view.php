<?php

/* @var $this yii\web\View */

$this->title = $model->title;

if (isset($heritage))
	$this->params['breadcrumbs'][] = ['label' => $heritage->short_name, 'url' => ['/heritage/view', 'slug' => $heritage->slug]];

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="poi-view">

	<?= $this->render('/common/_jumbotron', ['models' => $content->media]) ?>

	<?= $this->render('_info', [
		'model' => $model,
		'content' => $content,
		'heritage' => $heritage
	]) ?>
	
	<?= $this->render('/common/_relatedContent', ['model' => $content]) ?>

</div>
