<?php
use yii\helpers\Html;
use common\models\Tag;
use kartik\select2\Select2;
?>

<div class="form-group">

	<?= Html::activeLabel($model, 'tags') ?>
	
	<?= Select2::widget([
		'name' => ucfirst($model->tableName()) .'[tags]',
		'value' => $tagValue,
		'data' => Tag::getTagList(),
		'maintainOrder' => true,
		'showToggleAll' => false,
		'options' => [
			'placeholder' => Yii::t('app', 'Select tags'), 
			'multiple' => true
		],
		'pluginOptions' => [
			'tags' => true,
			'maximumInputLength' => 20
		]
	]) ?>
	
</div>