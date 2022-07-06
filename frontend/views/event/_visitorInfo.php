<?php if (!empty($model->arrival_station)): ?>
	<div class="card trip-card margin-bottom-lg">
		<div class="card-header collapsed" data-toggle="collapse" data-target="#visitor-info">
			<svg class="handle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34.42 58.95"><g><path fill="none" stroke="#fff" stroke-miterlimit="10" stroke-width="7" d="M2.48 2.48l27 27-27 27" /></g></svg>
			<div class="h4"><?= Yii::t('app', 'Visitor info') ?></div>
		</div>
		<div id="visitor-info" class="card-body collapse">
			<ul class="trip-list list-unstyled">
				<li>
					<a class="btn btn-primary btn-sm pull-right" target="_blank" href="<?= Yii::$app->helpers->getSbbLink($model->arrival_station) ?>">
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
			</ul>
		</div>
	</div>
<?php
else:
	if ($route = $model->eventRoute)
		echo $this->render('/route/_visitorInfo.php', ['model' => $route, 'showRouteLink' => true]);
endif;
?>