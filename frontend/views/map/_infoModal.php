<?php
use yii\helpers\Url;

$content = $model->content;
$type = $content->typeText;
$url = Url::toRoute([$type .'/view', 'slug' => $model->slug]);
$img = $content->previewImage;
?>

<div class="card preview-card map-preview">	
	<div class="row">
		<div class="col-md-4 header-container">
			<div class="card-header img-header class="col-sm-4">
				<a class="img-link" href="<?= $url ?>">
					<img class="card-img-top" src="<?= $img['url'] ?>" alt="<?= $img['alt'] ?>">
				</a>
			</div>
		</div>
		<div class="col-md-8">
			<div class="card-body small">
		
				<div class="label margin-bottom-sm">
					<?= $model->label ?><br />
					<em><?= $content->heritage->short_name ?></em>
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
</div>
