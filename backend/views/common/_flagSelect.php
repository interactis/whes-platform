<?php
use yii\helpers\Html;
use common\models\Flag;
use kartik\select2\Select2;
?>

<div class="form-group">

	<?= Html::activeLabel($model, 'flags') ?>
	
	<?= Select2::widget([
		'name' => ucfirst($model->tableName()) .'[flags]',
		'value' => $flagValue,
		'data' => Flag::getFlagList(),
		'maintainOrder' => true,
		'showToggleAll' => false,
		'options' => [
			'placeholder' => Yii::t('app', 'Select filters'), 
			'multiple' => true
		],
		'pluginOptions' => [
			'tags' => true,
			'maximumInputLength' => 20
		]
	]) ?>
	
</div>