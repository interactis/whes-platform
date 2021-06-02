<?php
use common\models\Heritage;
?>

<div class="overview-map-container text-center">
	<div class="overview-map">
		<div class="map-img-container">
			<img class="map-img" src="/img/layout/map.svg" alt="<?= Yii::t('app', 'Map') ?>">
		
			<?php
			foreach(Heritage::getActiveHeritages() as $model): ?>	
				<div class="poi" 
					style="top:<?= $model->map_position_y ?>%; left: <?= $model->map_position_x ?>%;" 
					data-toggle="popover" 
					data-placement="top" 
					data-html="true" 
					data-content="<?= $this->render('_popover', ['model' => $model]) ?>">
				</div>
			<?php endforeach; ?>
		</div>
		
	</div>
</div>
