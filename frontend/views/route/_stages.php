<?php
$content = $model->content;
$currentId = $content->id;
$childContents = $content->activeChildContents;
$count = count($childContents);

if ($count == 0)
{
	$parentContents = $content->getActiveParentContents('route');
	
	if (isset($parentContents[0]))
	{
		$model = $parentContents[0]->route;
		$childContents = $parentContents[0]->activeChildContents;
		$count = count($childContents);
	}
}
?>

<?php if ($count > 0): ?>
	<div class="card margin-bottom-md">
		<div class="card-header dark">
			<div class="h4"><?= Yii::t('app', 'Stages') ?></div>
			<div class="h5 text-center">
				<a href="<?= '/'. Yii::t('app', 'route') .'/'. $model->slug ?>">
					<?= $model->title ?>
				</a>
			</div>
		</div>
		<div class="card-body">
			<ul class="list-unstyled">
				<?php
				$i = 1;
				foreach($childContents as $content):
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
						
						<label>
							<?= Yii::t('app', 'Stage') ?> <?= $i ?>
							<?php if ($currentId == $content->id): ?>
								&nbsp;<i class="fa fa-circle text-primary"></i>
							<?php endif; ?>
						</label>
						<div class="h4">
							<a href="<?= $infoUrl ?>">
								<?= $model->title ?>
							</a>
						</div>
					</li>
				<?php
				$i = $i+1;
				endforeach; ?>
			</ul>
		</div>
	</div>
<?php endif ?>
