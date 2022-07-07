<?php
use common\models\Heritage;
use yii\helpers\ArrayHelper;

if (!isset($showChildContent))
	$showChildContent = false;

$tagValue = [];
if (isset($model->content->contentTags))
	$tagValue = ArrayHelper::map($model->content->contentTags, 'tag_id', 'tag_id');

$flagValue = [];
if (isset($model->content->contentFlags))
	$flagValue = ArrayHelper::map($model->content->contentFlags, 'flag_id', 'flag_id');

$childContentValue = [];
if (isset($model->content->childContent))
	$childContentValue = ArrayHelper::map($model->content->childContent, 'child_id', 'child_id');
	
$user = Yii::$app->user->identity;
?>

<div id="relations" class="panel panel-default">
	<div class="panel-heading">
		<h3>Relations</h3>
	</div>
	
	<div class="panel-body">		
		<?php
		if ($user->isAdmin())
		{
			echo $form->field($contentModel, 'heritage_id')->dropDownList(
				Heritage::getHeritages(),
				['prompt' => Yii::t('app', 'Please select')]
			);
		}
		?>
	
		<?= $this->render('/common/_tagSelect', [
			'model' => $model,
			'tagValue' => $tagValue
		]); ?>
		
		<?= $this->render('/common/_flagSelect', [
			'model' => $model,
			'flagValue' => $flagValue
		]); ?>
		
		<?php
		if ($showChildContent)
		{
			echo $this->render('/common/_childContentSelect', [
				'model' => $model,
				'childContentValue' => $childContentValue,
				'childContentType' => $childContentType
			]);
		}
		?>
	</div>
</div>