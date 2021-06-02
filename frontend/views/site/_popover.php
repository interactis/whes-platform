<?php
use yii\helpers\Url;

$url = Url::toRoute(['heritage/view', 'slug' => $model->slug]);
$img = $model->previewImage;
?>

<div class='card preview-card popover-card'>	
	<div class='card-header img-header'>
		<a class='img-link' href='<?= $url ?>'>
			<img class='img-fluid' src='<?= $img['url'] ?>'>
		</a>
	</div>
	<div class='card-body small'>
		<div class='h4 margin-bottom-sm'>
			<a href='<?= $url ?>'><?= $model->short_name ?></a>
		</div>
		<a href='<?= $url ?>'>
			<i class='fa fa-chevron-right'></i> 
			<?= Yii::t('app', 'Learn more') ?>
		</a>
	</div>
</div>
