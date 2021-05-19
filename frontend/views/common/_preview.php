<?php
use yii\helpers\Url;

$type = $content->typeText;
$model = $content->{$type};
$url = Url::toRoute([$type .'/view', 'slug' => $model->slug]);
$img = $content->previewImage;

$maxLenght = 160;
$description = strip_tags($model->description);

if (strlen($description) > $maxLenght)
	$description = substr($description, 0, strpos($description, ' ', $maxLenght)) .' ...';
?>

<div class="col-md-6 col-lg-4 px-md-4 px-lg-3 px-xl-4">
	<div class="card preview-card">	
		<div class="card-header img-header">
			<a class="img-link" href="<?= $url ?>">
				<img class="card-img-top" src="<?= $img['url'] ?>" alt="<?= $img['alt'] ?>">
			</a>
		</div>
		<div class="card-body small">
			<div class="h3 card-title"><?= $model->title ?></div>
			<p class="card-text"><?= $description ?></p>
			<a href="<?= $url ?>">
				<i class="fa fa-chevron-right"></i> 
				<?= Yii::t('app', 'Learn more') ?>
			</a>
		</div>
	</div>
</div>
