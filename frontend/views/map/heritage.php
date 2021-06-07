<?php
use frontend\components\mapwidget\MapWidget;

$this->title = Yii::t('app', 'Map');
?>

<div class="map-view">
	<?= MapWidget::widget([]) ?>
</div>

<span id="map-initial-icons"
	data-value="heritage-<?= $model->id ?>">
</span>
<span class="map-item"
	data-content-type="heritage"
	data-id="<?= $model->id ?>"
	data-geodata='{"latitude": <?= $model->geom[0] ?>, "longitude": <?= $model->geom[1] ?>}'>
</span>
