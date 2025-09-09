<?php
if (in_array($model->id, Yii::$app->params['conversionPages'][Yii::$app->params['frontendType']]['page']))
	Yii::$app->params['isConversionPage'] = true;

$this->title = Yii::t('app', 'Our Heritage');
?>
<div class="site-index">

	<?= $this->render('/common/_jumbotron', ['models' => $media]) ?>

	<?= $this->render('_intro', ['model' => $model]) ?>
	
	<?php if (Yii::$app->params['frontendType'] == 'edu'): ?>
		<div class="spacer"></div>
	<?php endif; ?>
	
	<?= $this->render('/common/_filter', [
		'content' => $content,
		'filters' => $filters,
		'totalContent' => $totalContent,
		'showMoreBtn' => $showMoreBtn
	]) ?>
	
	<?php
	if (Yii::$app->params['frontendType'] == 'edu')
	{
		echo $this->render('_overviewMap');
		echo '<div class="spacer">&nbsp;</div>';
	}
	?>
	
</div>
