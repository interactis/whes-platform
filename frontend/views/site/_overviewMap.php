<?php
use yii\helpers\Url;
use common\models\Heritage;
?>

<div class="overview-map-container text-center">
	<div class="overview-map">
		<img class="map-img" src="/img/layout/map.svg">
		
		
		<?php
		foreach(Heritage::getActiveHeritages() as $model):
			$url = Url::toRoute(['heritage/view', 'slug' => $model->slug]);
			$img = $model->previewImage;
			
			/*
			$popoverContent = '<a class=\'img-link\' href=\''. $url .'\'>
					<img class=\'img-fluid\' src=\''. $img['url'] .'\'>
				</a>';
			*/	
				
			$popoverContent = '<div class=\'h4\'>
					<a href=\''. $url .'\'>'. $model->short_name .'</a>
				</div>
				<a href=\''. $url .'\'>
					<i class=\'fa fa-chevron-right\'></i> 
					'. Yii::t('app', 'Learn more') .'
				</a>';
			?> 
		
			<div class="poi" 
				style="top:5.5%; left: 50.34%;" 
				data-toggle="popover" 
				data-placement="top" 
				data-html="true" 
				data-content="<?= $popoverContent ?>">
			</div>
			
		<?php endforeach; ?>
		
	</div>
</div>
