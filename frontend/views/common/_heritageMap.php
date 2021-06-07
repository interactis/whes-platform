<?php
use yii\helpers\Url;

$url = false;

switch ($model->tableName()) {
	 case 'heritage':
    	$heritage = $model;
    	if (!empty($model->geom))
    		$url = Url::to(['map/heritage', 'id' => $model->id]);
        break;
    case 'poi':
    	if (!empty($model->geom))
        	$url = Url::to(['map/poi', 'id' => $model->id]);
        break;
    case 'route':
    	if (!empty($model->geom))
    		$url = Url::to(['map/route', 'id' => $model->id]);
        break;
}
?>

<?php if ($url): ?>
	<div class="margin-bottom-lg text-center">
		
		<div class="heritage-map">
			<a href="<?= $url ?>" title="<?= Yii::t('app', 'Show map') ?>">
				<img src="/img/layout/map.svg" class="map-img" alt="<?= Yii::t('app', 'Map') ?>">
			</a>
			<a class="poi" href="<?= $url ?>" title="<?= Yii::t('app', 'Show map') ?>" style="top:<?= $heritage->map_position_y ?>%; left: <?= $heritage->map_position_x ?>%;"></a>
		</div>
		
		<a href="<?= $url ?>" title="<?= Yii::t('app', 'Show map') ?>">
			<i class="fa fa-map-marker"></i> 
			<?= Yii::t('app', 'Show map') ?>
		</a>
	</div>
<?php endif; ?>
