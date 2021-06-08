<?php
use yii\helpers\Url;

$type = $content->typeText;

if (!isset($model))
	$model = $content->{$type};

$url = Url::toRoute([$type .'/view', 'slug' => $model->slug]);
$img = $content->previewImage;
?>

<div class="col-md-6 col-lg-4"> 
	<div class="card preview-card">	
		<div class="card-header img-header">
			<a class="img-link" href="<?= $url ?>">
				<img class="card-img-top" src="<?= $img['url'] ?>" alt="<?= $img['alt'] ?>">
			</a>
		</div>
		<div class="card-body small">
			
			<div class="label margin-bottom-sm">
				<?= $model->label ?>
			</div>
			
			<div class="h3 card-title">
				<a href="<?= $url ?>">
					<?= $model->title ?>
				</a>
			</div>
			<div class="card-text">
				<?= Yii::$app->helpers->shortenString($model->description) ?>
			</div>
			<a href="<?= $url ?>">
				<i class="fa fa-chevron-right"></i> 
				<?= Yii::t('app', 'Learn more') ?>
			</a>
		</div>
	</div>
</div>
