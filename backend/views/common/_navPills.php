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
	<li class="nav-tab <?= ($active == 1) ? 'active' : ''; ?>"><?= Html::a('<span class="glyphicon glyphicon-info-sign"></span> '. Yii::t('app', 'Info'), Yii::$app->urlManager->createUrl([$model->tableName() .'/update', 'id' => $model->id])) ?></li>
	<li class="nav-tab <?= ($active == 2) ? 'active' : ''; ?>"><?= Html::a('<span class="glyphicon glyphicon-picture"></span> '. Yii::t('app', 'Images'), Yii::$app->urlManager->createUrl(['media/'. $model->tableName(), 'id' => $model->id])) ?></li>
	<li class="nav-tab <?= ($active == 3) ? 'active' : ''; ?>"><?= Html::a('<span class="glyphicon glyphicon-list-alt"></span> '. Yii::t('app', 'Factsheet'), Yii::$app->urlManager->createUrl(['profile-item/index', 'id' => $model->id])) ?></li>
</ul>