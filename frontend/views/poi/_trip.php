
<?php if (!empty($model->arrival_station)): ?>
	<div class="card margin-bottom-lg">
		<div class="card-header">
			<div class="h4"><?= Yii::t('app', 'Trip Description') ?></div>
		</div>
		<div class="card-body">
			<ul class="trip-list list-unstyled">
				<li>
					<?php if (!empty($model->arrival_url)): ?>
						<a class="btn btn-primary btn-sm pull-right" href="https://www.sbb.ch/" target="_blank">
							<?= Yii::t('app', 'Schedule') ?>
						</a>
					<?php endif; ?>
					
					<div class="h3"><?= Yii::t('app', 'Journey') ?></div>
					<div><?= Yii::t('app', 'to') ?> <?= $model->arrival_station ?></div>
				</li>
				
				<?php if (!empty($model->directions)): ?>
					<li class="even">
						<?= $model->directions ?>
					</li>
				<?php endif; ?>
				
				<?php
				/*
				<li class="even">
					<a class="btn btn-primary btn-sm pull-right" href="https://www.sbb.ch/" target="_blank">
						<?= Yii::t('app', 'Schedule') ?>
					</a>
					<div class="h3"><?= Yii::t('app', 'Return trip') ?></div>
					<div><?= Yii::t('app', 'from') ?> Jungfraujoch</div>
				</li>
				*/
				?>
			
			</ul>
		</div>
	</div>
<?php endif; ?>