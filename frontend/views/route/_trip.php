
<?php if (!empty($model->arrival_station)): ?>
	<div class="card trip-card margin-bottom-lg">
		<div class="card-header">
			<div class="h4"><?= Yii::t('app', 'Trip Description') ?></div>
		</div>
		<div class="card-body">
			<ul class="trip-list list-unstyled">
				<li>
					<a class="btn btn-primary btn-sm pull-right" href="<?= Yii::$app->helpers->getSbbLink($model->arrival_station) ?>">
						<?= Yii::t('app', 'Schedule') ?>
					</a>
					<div class="h3"><?= Yii::t('app', 'Journey') ?></div>
					<div><?= Yii::t('app', 'to') ?> <?= $model->arrival_station ?></div>
				</li>
				
				<?php if (!empty($model->directions)): ?>
					<li>
						<?= $model->directions ?>
					</li>
				<?php endif; ?>
				
				<?php if (!empty($model->departure_station)): ?>
					<li>
						<div class="h3"><?= $model->title ?></div>
						<div>
							<?= $model->label ?>
							<?= (!empty($model->difficulty) ? '<span class="thin">'. $model->difficultyText .'</thin>' : '') ?>
						</div>
					</li>
					<li>
						<a class="btn btn-primary btn-sm pull-right" href="<?= Yii::$app->helpers->getSbbLink($model->departure_station, 'von') ?>">
							<?= Yii::t('app', 'Schedule') ?>
						</a>
						<div class="h3"><?= Yii::t('app', 'Return trip') ?></div>
						<div><?= Yii::t('app', 'from') ?> <?= $model->departure_station ?></div>
					</li>
				<?php endif; ?>
			
			</ul>
		</div>
	</div>
<?php endif; ?>