<?php
use frontend\components\mapwidget\MapWidget;

$this->title = Yii::t('app', 'Map');
?>

<div class="map-view">
	<?= MapWidget::widget([]) ?>
</div>

<?php /* <span id="map-initial-icons" data-value="<?= $initialIcons ?>"></span> */ ?>
