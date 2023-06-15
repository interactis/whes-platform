<?php
use yii\helpers\Html;
use common\models\Flag;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

$flagValue = [];
if (isset($contentModel->contentFlags))
	$flagValue = ArrayHelper::map($contentModel->getContentFlags($type), 'flag_id', 'flag_id');
	
$frontendUrl = Yii::$app->params['frontendUrl'];
if ($type == 'edu')
	$frontendUrl = Yii::$app->params['eduUrl'];
?>

<div class="form-group">
	<?= Html::activeLabel($model, $type .'Flags') ?>
	
	<?= Select2::widget([
		'name' => ucfirst($model->tableName()) .'['. $type .'Flags]',
		'value' => $flagValue,
		'data' => Flag::getFlagList($type),
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
	
	<div class="hint-block">If set, the content will appear on <a href="<?= $frontendUrl ?>" target="_blank"><?= $frontendUrl ?></a>.</div>
</div>
