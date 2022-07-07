<?php
$childContents = $model->content->activeChildContents;
$count = count($childContents);

$title = Yii::t('app', 'Location');
if ($count > 1)
	$title = Yii::t('app', 'Locations');

if ($count > 0): ?>
	<div class="card margin-bottom-md">
		<div class="card-header">
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
							<a class="btn btn-primary btn-sm pull-right" href="<?= $mapUrl ?>">
								<?= Yii::t('app', 'Map') ?>
							</a>
						<?php endif; ?>
						
						<label><?= $model->label ?></label>
						<a href="<?= $infoUrl ?>">
							<div class="h4"><?= $model->title ?></div>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
<?php endif ?>
