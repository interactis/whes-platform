<?php
use yii\helpers\Html;
use common\models\Content;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

$childContentValue = [];
if (isset($contentModel->childContents))
	$childContentValue = ArrayHelper::map($contentModel->childContents, 'child_content_id', 'child_content_id');
?>

<div class="form-group">

	<?= Html::activeLabel($model, 'childContentIds') ?>
	
	<?= Select2::widget([
		'name' => ucfirst($model->tableName()) .'[childContentIds]',
		'value' => $childContentValue,
		'data' => Content::getContentList(false, [$model->content_id], $childContentTypeIds, $childContentValue),
		'maintainOrder' => true,
		'showToggleAll' => false,
		'options' => [
			'placeholder' => Yii::t('app', 'Please select'), 
			'multiple' => true
		],
		'pluginOptions' => [
			'tags' => true,
			'maximumInputLength' => 20
		]
	]) ?>
	
	<?php if ($childContentHint): ?>
		<div class="hint-block"><?= $childContentHint ?></div>
	<?php endif; ?>
	
</div>