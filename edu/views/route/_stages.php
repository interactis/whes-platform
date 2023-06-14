<?php if ($stages = $model->stages): ?>
	<div class="card max-height margin-bottom-md">
		<div class="card-header dark">
			<div class="h4"><?= Yii::t('app', 'Stages') ?></div>
			<div class="h5 text-center">
				<a href="<?= '/'. Yii::t('app', 'route') .'/'. $stages['parentRoute']->slug ?>">
					<?= $stages['parentRoute']->title ?>
				</a>
			</div>
		</div>
		<div class="card-body">
			<ul class="list-unstyled">
				<?php
				$i = 1;
				foreach($stages['childContents'] as $content):
					$model = $content->route;
					$infoUrl = '/'. Yii::t('app', 'route') .'/'. $model->slug;
					
					$mapUrl = false;
					if (isset($model->geom) && !empty($model->geom))
						$mapUrl = '/map/route/'. $model->id;
					?>
					
					<li>
						<?php if ($mapUrl): ?>
							<a class="btn btn-dark btn-sm pull-right" href="<?= $mapUrl ?>">
								<?= Yii::t('app', 'Map') ?>
							</a>
						<?php endif; ?>
						
						<label>
							<?= Yii::t('app', 'Stage') ?> <?= $i ?>
							<?php if ($stages['currentChild'] && $stages['currentChild']['content']->id == $content->id): ?>
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
