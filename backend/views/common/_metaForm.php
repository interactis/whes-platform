<?php
use yii\helpers\ArrayHelper;

$tagValue = [];
if (isset($model->content->contentTags))
	$tagValue = ArrayHelper::map($model->content->contentTags, 'tag_id', 'tag_id');

$flagValue = [];
if (isset($model->content->contentFlags))
	$flagValue = ArrayHelper::map($model->content->contentFlags, 'flag_id', 'flag_id');
?>

<div id="meta" class="panel panel-default">
	<div class="panel-heading">
		<h3>Meta Data</h3>
	</div>
	
	<div class="panel-body">
		<?= Yii::$app->controller->renderPartial('//common/_tagSelect', [
			'model' => $model,
			'tagValue' => $tagValue
		]); ?>
		
		<?= Yii::$app->controller->renderPartial('//common/_flagSelect', [
			'model' => $model,
			'flagValue' => $flagValue
		]); ?>
	</div>
</div>