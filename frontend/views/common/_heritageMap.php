<?php
use yii\helpers\Url;

$url = false;

switch ($model->tableName()) {
    case 'poi':
    	if (!empty($model->geom))
        	$url = Url::to(['map/index', 'select' => 'poi', 'id' => $model->id]);
        break;
    case 'route':
    	if (!empty($model->geom))
    		$url = Url::to(['map/index', 'select' => 'route', 'id' => $model->id]);
        break;
    case 'heritage':
    	// if (!empty($model->geom))
    		$url = Url::to(['map/index', 'select' => 'heritage', 'id' => $model->id]);
        break;
}
?>

<?php if ($url): ?>
	<div class="margin-bottom-lg text-center">
		<a href="<?= $url ?>">
			<img src="/img/layout/map.svg" class="img-fluid w-100" alt="<?= Yii::t('app', 'Map') ?>">
		</a>
		<a href="<?= $url ?>">
			<i class="fa fa-map-marker"></i> 
			<?= Yii::t('app', 'Show map') ?>
		</a>
	</div>
<?php endif; ?>
