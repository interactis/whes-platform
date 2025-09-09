<?php
if (in_array($model->id, Yii::$app->params['conversionPages'][Yii::$app->params['frontendType']]['heritage']))
	Yii::$app->params['isConversionPage'] = true;

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
		'heritageFilters' => $heritageFilters,
		'totalContent' => $totalContent,
		'showMoreBtn' => $showMoreBtn
	]) ?>
	
</div>
