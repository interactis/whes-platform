<?php
use common\models\Heritage;
?>

<div class="overview-map-container text-center container margin-bottom-lg">
	<div class="overview-map">
		<img class="map-img" src="<?= Yii::$app->params['frontendUrl'] ?>img/layout/map.svg" alt="<?= Yii::t('app', 'Map') ?>">
	
		<?php
		foreach(Heritage::getActiveHeritages() as $model): ?>	
			<div class="poi poi-type-<?= $model->type ?>" 
				style="top:<?= $model->map_position_y ?>%; left: <?= $model->map_position_x ?>%;" 
				data-toggle="popover" 
				data-placement="top" 
				data-html="true" 
				data-trigger="manual" 
				data-animation="false"
				data-content="<?= $this->render('_popover', ['model' => $model]) ?>">
			</div>
		<?php endforeach; ?>
	</div>
	
	<?php if (Yii::$app->params['frontendType'] == 'visitor'): ?>
		<a href="/map" title="<?= Yii::t('app', 'Show map') ?>">
			<i class="fa fa-map-marker"></i> 
			<?= Yii::t('app', 'Show map') ?>
		</a>
	<?php endif; ?>
</div>
