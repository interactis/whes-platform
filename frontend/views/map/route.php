<?php
use frontend\components\mapwidget\MapWidget;

$this->title = Yii::t('app', 'Map');
?>

<div class="map-view">
	<?= MapWidget::widget([]) ?>
</div>

<span id="map-initial-icons"
	data-value="trail-<?= $model->id ?>">
</span>
<span class="map-item"
	data-content-type="trail"
	data-id="<?= $model->id ?>"
	data-geodata='{"trail": <?= json_encode($model->geom) ?>}'>
</span>
	