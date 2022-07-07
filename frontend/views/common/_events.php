<?php
$parentContents = $model->content->activeParentContents;

if (count($parentContents) > 0): ?>
	<div class="card margin-bottom-md">
		<div class="card-header dark">
			<div class="h4"><?= Yii::t('app', 'Events') ?></div>
		</div>
		<div class="card-body">
			<ul class="list-unstyled">
				<?php foreach($parentContents as $content):
					$type = $content->typeText;
					$model = $content->{$type};
					$infoUrl = '/'. Yii::t('app', $type) .'/'. $model->slug;
					
					$mapUrl = false;
					if (isset($model->geom) && !empty($model->geom))
						$mapUrl = '/map/'. Yii::t('app', $type) .'/'. $model->id;
					?>
					
					<li>
						<?php /* <label><?= $model->label ?></label> */ ?>
						<a href="<?= $infoUrl ?>">
							<div class="h4"><?= $model->title ?></div>
						</a>
						<?php if (isset($model->fromTo)): ?>
							<div class="h5">
								<?= $model->getFromTo(true) ?>
							</div>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
<?php endif ?>
