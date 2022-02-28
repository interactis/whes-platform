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
?>

<ul class="nav nav-tabs main-nav-tabs">
	<li class="nav-tab <?= ($active == 1) ? 'active' : ''; ?>"><?= Html::a('<span class="glyphicon glyphicon-qrcode"></span> '. Yii::t('app', 'Codes'), Yii::$app->urlManager->createUrl(['code/index', 'id' => $model->id])) ?></li>
	<li class="nav-tab <?= ($active == 2) ? 'active' : ''; ?>"><?= Html::a('<span class="glyphicon glyphicon-folder-close"></span> '. Yii::t('app', 'Code Groups'), Yii::$app->urlManager->createUrl(['code-group/index', 'id' => $model->id])) ?></li>
</ul>