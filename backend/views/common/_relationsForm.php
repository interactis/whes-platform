<?php
use common\models\Heritage;
use common\models\Supplier;
use yii\helpers\ArrayHelper;

if (!isset($showChildContent))
	$showChildContent = false;

$tagValue = [];
if (isset($contentModel->contentTags))
	$tagValue = ArrayHelper::map($contentModel->contentTags, 'tag_id', 'tag_id');

$flagValue = [];
if (isset($contentModel->contentFlags))
	$flagValue = ArrayHelper::map($contentModel->contentFlags, 'flag_id', 'flag_id');

$childContentValue = [];
if (isset($contentModel->childContents))
	$childContentValue = ArrayHelper::map($contentModel->childContents, 'child_content_id', 'child_content_id');

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
		
		<?php
		$type = $contentModel->types[$contentModel->type];
		if ($type != 'article')
		{
			echo $form->field($contentModel, 'supplier_id')->dropDownList(
				Supplier::getSuppliers(),
				['prompt' => Yii::t('app', 'Please select')]
			)->hint('<a href="/supplier" target="_blank"><span class="glyphicon glyphicon-new-window"></span> Manage suppliers</a>');
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
				'childContentTypeIds' => $childContentTypeIds,
				'childContentHint' => $childContentHint
			]);
		}
		?>
		
		<?php
		if ($user->isAdmin())
		{
			echo $form->field($model, 'external_id');
		}
		?>
		
	</div>
</div>