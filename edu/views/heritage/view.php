<?php

/* @var $this yii\web\View */

$this->title = $model->short_name;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="heritage-view">

	<?= $this->render('/common/_jumbotron', ['models' => $model->media]) ?>

	<?= $this->render('_intro', ['model' => $model]) ?>
	
	<?= $this->render('/common/_filter', [
		'content' => $content,
		'heritageId' => $model->id,
		'filters' => $filters,
		'heritageFilters' => $heritageFilters
	]) ?>
	
</div>
