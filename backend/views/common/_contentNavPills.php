<?php
use yii\helpers\Html;

$js = "
	var formChanges = false;
	$('input, textarea, select').change(function() {
		formChanges = true;
	});
	
	$('body').on('click', '.nav-tab', function(event) {
		if (formChanges == true) {
			event.preventDefault()
			alert('Please save your changes before you leave the page.');
		}
	});
";

$this->registerJs($js, $this::POS_READY);

$type = $model->types[$model->type];
$contentModel = $model->{$type};
?>

<ul class="nav nav-tabs main-nav-tabs">
	<li class="nav-tab <?= ($active == 'info') ? 'active' : ''; ?>"><?= Html::a('<span class="glyphicon glyphicon-info-sign"></span> '. Yii::t('app', 'Info'), Yii::$app->urlManager->createUrl([$contentModel->tableName() .'/update', 'id' => $contentModel->id])) ?></li>
	<li class="nav-tab <?= ($active == 'img') ? 'active' : ''; ?>"><?= Html::a('<span class="glyphicon glyphicon-picture"></span> '. Yii::t('app', 'Images'), Yii::$app->urlManager->createUrl(['media/'. $model->tableName(), 'id' => $model->id])) ?></li>
	<li class="nav-tab <?= ($active == 'audio') ? 'active' : ''; ?>"><?= Html::a('<span class="glyphicon glyphicon-headphones"></span> '. Yii::t('app', 'Audio'), Yii::$app->urlManager->createUrl(['audio/index', 'id' => $model->id])) ?></li>
	<li class="nav-tab <?= ($active == 'download') ? 'active' : ''; ?>"><?= Html::a('<span class="glyphicon glyphicon-download"></span> '. Yii::t('app', 'Downloads'), Yii::$app->urlManager->createUrl(['download/index', 'id' => $model->id])) ?></li>
</ul>