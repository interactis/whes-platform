<?php
$childContents = $model->content->activeChildContents;
$count = count($childContents);

$title = Yii::t('app', 'Event location');
if ($count > 1)
	$title = Yii::t('app', 'Event locations');

if ($count > 0): ?>
	<div class="card margin-bottom-md">
		<div class="card-header dark">
			<div class="h4"><?= $title ?></div>
		</div>
		<div class="card-body">
			<ul class="list-unstyled">
				<?php foreach($childContents as $content):
					$type = $content->typeText;
					$model = $content->{$type};
					$infoUrl = '/'. Yii::t('app', $type) .'/'. $model->slug;
					
					$mapUrl = false;
					if (isset($model->geom) && !empty($model->geom))
						$mapUrl = '/map/'. Yii::t('app', $type) .'/'. $model->id;
					?>
					
					<li>
						<?php if ($mapUrl): ?>
							<a class="btn btn-dark btn-sm pull-right" href="<?= $mapUrl ?>">
								<?= Yii::t('app', 'Map') ?>
							</a>
						<?php endif; ?>
						
						<label><?= $model->label ?></label>
						<div class="h4">
							<a href="<?= $infoUrl ?>">
								<?= $model->title ?>
							</a>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
<?php endif ?>
