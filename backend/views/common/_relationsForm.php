<?php
use common\models\Heritage;
use yii\helpers\ArrayHelper;

$tagValue = [];
if (isset($model->content->contentTags))
	$tagValue = ArrayHelper::map($model->content->contentTags, 'tag_id', 'tag_id');

$flagValue = [];
if (isset($model->content->contentFlags))
	$flagValue = ArrayHelper::map($model->content->contentFlags, 'flag_id', 'flag_id');
	
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