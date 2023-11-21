<?php
use common\models\Heritage;
use common\models\Supplier;

if (!isset($showChildContent))
	$showChildContent = false;

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
			'contentModel' => $contentModel
		]) ?>
		
		<?= $this->render('/common/_flagSelect', [
			'model' => $model,
			'contentModel' => $contentModel,
			'type' => 'visitor'
		]) ?>
		
		<?= $this->render('/common/_flagSelect', [
			'model' => $model,
			'contentModel' => $contentModel,
			'type' => 'edu'
		]) ?>
		
		<?php
		if ($user->isAdmin())
		{
			echo $this->render('/common/_flagSelect', [
				'model' => $model,
				'contentModel' => $contentModel,
				'type' => 'eut'
			]);
		}
		?>
		
		<?php
		if ($showChildContent)
		{
			echo $this->render('/common/_childContentSelect', [
				'model' => $model,
				'contentModel' => $contentModel,
				'childContentTypeIds' => $childContentTypeIds,
				'childContentHint' => $childContentHint
			]);
		}
		?>
		
		<?php
		if ($user->isAdmin() && $type != 'event')
		{
			echo $form->field($model, 'external_id');
		}
		?>
		
	</div>
</div>