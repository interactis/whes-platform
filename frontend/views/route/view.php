<?php

/* @var $this yii\web\View */

$this->title = $model->title;

$this->params['breadcrumbs'][] = ['label' => $heritage->short_name, 'url' => ['/heritage/view', 'slug' => $heritage->slug]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="route-view">

	<?= $this->render('/common/_jumbotron', ['models' => $content->media]) ?>

	<?= $this->render('_info.php', [
		'model' => $model,
		'content' => $content,
		'heritage' => $heritage
	]) ?>

</div>
