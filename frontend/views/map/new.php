<?php
use frontend\components\map\Map;

$this->title = Yii::t('app', 'Map');
?>

<div class="map-view">
	<?= Map::widget([
		'initialItem' => $initialItem,
		'translations' => $translations
	]) ?>
</div>
