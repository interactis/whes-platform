
<?php if (!empty($model->arrival_station)): ?>
	<div class="card margin-bottom-lg">
		<div class="card-header">
			<div class="h4"><?= Yii::t('app', 'Trip Description') ?></div>
		</div>
		<div class="card-body">
			<ul class="trip-list list-unstyled">
				<li>
					<?php if (!empty($model->arrival_url)): ?>
						<a class="btn btn-primary btn-sm pull-right" href="<?= $model->arrival_url ?>" target="_blank">
							<?= Yii::t('app', 'Schedule') ?>
						</a>
					<?php endif; ?>
					
					<div class="h3"><?= Yii::t('app', 'Journey') ?></div>
					<div><?= Yii::t('app', 'to') ?> <?= $model->arrival_station ?></div>
				</li>
				
				<li class="even">
					<div class="h3"><?= $model->title ?></div>
					<div>
						<?= Yii::t('app', 'Route') ?>
						<?= (!empty($model->difficulty) ? '<span class="thin">'. $model->difficulties[$model->difficulty] .'</thin>' : '') ?>
					</div>
				</li>
				
				
				<?php if (!empty($model->departure_station)): ?>
					<li>
						<?php if (!empty($model->departure_url)): ?>
							<a class="btn btn-primary btn-sm pull-right" href="<?= $model->departure_url ?>" target="_blank">
								<?= Yii::t('app', 'Schedule') ?>
							</a>
						<?php endif; ?>
					
						<div class="h3"><?= Yii::t('app', 'Return trip') ?></div>
						<div><?= Yii::t('app', 'from') ?> <?= $model->departure_station ?></div>
					</li>
				<?php endif; ?>
			
			</ul>
		</div>
	</div>
<?php endif; ?>