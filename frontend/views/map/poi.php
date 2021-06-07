<?php
use frontend\components\mapwidget\MapWidget;

$this->title = Yii::t('app', 'Map');
?>

<div class="map-view">
	<?= MapWidget::widget([]) ?>
</div>

<span id="map-initial-icons"
	data-value="poi-<?= $model->id ?>">
</span>
<span class="map-item"
	data-content-type="poi"
	data-id="<?= $model->id ?>"
	data-geodata='{"latitude": <?= $model->geom[0] ?>, "longitude": <?= $model->geom[1] ?>}'>
</span>

