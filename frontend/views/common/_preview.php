<?php
use yii\helpers\Html;

$type = $content->typeText;
$model = $content->{$type};

$imgUrl = '';
$url = '';

$maxLenght = 160;
$description = strip_tags($model->description);
if (strlen($description) > $maxLenght)
	$description = substr($description, 0, strpos($description, ' ', $maxLenght)) .' ...';
?>

<div class="col-md-6 col-lg-4">
	<div class="card preview-card">	
		<div class="card-header img-header">
			<a class="img-link" href="<?= $url ?>">
				<img class="card-img-top" src="<?= $imgUrl ?>" alt="<?= Yii::t('app', 'Application image') ?>">
			</a>
		</div>
		<div class="card-body">
			<div class="h3 card-title"><?= $model->title ?></div>
			<p class="card-text"><?= $description ?></p>
			
			<?= Html::a('<i class="fa fa-chevron-right"></i> '. Yii::t('app', 'Learn more'), [$type .'/view', 'slug' => $model->slug]) ?>
		
		</div>
	</div>
</div>
