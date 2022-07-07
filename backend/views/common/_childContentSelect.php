<?php
use yii\helpers\Html;
use common\models\Content;
use kartik\select2\Select2;
?>

<div class="form-group">

	<?= Html::activeLabel($model, 'childContent') ?>
	
	<?= Select2::widget([
		'name' => ucfirst($model->tableName()) .'[childContent]',
		'value' => $childContentValue,
		'data' => Content::getContentList(false, $model->content_id, $childContentType),
		'maintainOrder' => true,
		'showToggleAll' => false,
		'options' => [
			'placeholder' => Yii::t('app', 'Select childrens'), 
			'multiple' => true
		],
		'pluginOptions' => [
			'tags' => true,
			'maximumInputLength' => 20
		]
	]) ?>
	
</div>