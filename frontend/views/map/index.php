<?php
use frontend\components\mapwidget\MapWidget;

$this->title = Yii::t('app', 'Map');
?>

<div class="map-view">
	<?= MapWidget::widget([]) ?>
</div>

<?php
// prettify after map update (this is a quick and dirty adaption mysa map handling)
if ($model): ?>

	<?php if ($model->tableName() == 'poi'): ?>
		<span id="map-initial-icons"
			data-value="<?= $model->tableName() .'-'. $model->id ?>">
		</span>
		<span class="map-item"
			data-content-type="poi"
			data-id="<?= $model->id ?>"
			data-geodata='{"latitude": <?= $model->geom[0] ?>, "longitude": <?= $model->geom[1] ?>}'>
		</span>
	<?php endif; ?>
	
	<?php if ($model->tableName() == 'route'): ?>
		<span id="map-initial-icons"
			data-value="trail-'. $model->id ?>">
		</span>
		<span class="map-item"
			data-content-type="trail"
			data-id="<?= $model->id ?>"
			data-geodata='{"trail": <?= json_encode($model->geom) ?>}'>
		</span>
	<?php endif; ?>
	
<?php endif; ?>