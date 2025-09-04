<?php if (!empty($model->keyFiguresSet)): ?>
	<div class="small margin-bottom-md">
		<div class="h3 margin-bottom-sm"><?= Yii::t('app', 'Short Info') ?></div>
		
		<dl class="row">
			
			<?php if (!empty($model->difficulty)): ?>
				<dt class="col-5 col-sm-4"><?= Yii::t('app', 'Difficulty') ?></dt>
				<dd class="col-7 col-sm-8"><?= $model->difficultyText ?></dd>
			<?php endif; ?>
			
			<?php if (!empty($model->distance_in_km)): ?>
				<dt class="col-5 col-sm-4"><?= Yii::t('app', 'Distance') ?></dt>
				<dd class="col-7 col-sm-8"><?= $model->distanceText ?></dd>
			<?php endif; ?>
			
			<?php if (!empty($model->duration_in_min)): ?>
				<dt class="col-5 col-sm-4"><?= Yii::t('app', 'Duration') ?></dt>
				<dd class="col-7 col-sm-8"><?= $model->durationText ?></dd>
			<?php endif; ?>
			
			<?php if (!empty($model->start_altitude)): ?>
				<dt class="col-5 col-sm-4"><?= Yii::t('app', 'Start altitude') ?></dt>
				<dd class="col-7 col-sm-8"><?= $model->getAltituteText('start_altitude') ?></dd>
			<?php endif; ?>
			
			<?php if (!empty($model->end_altitude)): ?>
				<dt class="col-5 col-sm-4"><?= Yii::t('app', 'End altitude') ?></dt>
				<dd class="col-7 col-sm-8"><?= $model->getAltituteText('end_altitude') ?></dd>
			<?php endif; ?>
			
			<?php if (!empty($model->ascent)): ?>
				<dt class="col-5 col-sm-4"><?= Yii::t('app', 'Ascent') ?></dt>
				<dd class="col-7 col-sm-8"><?= $model->getMetersText('ascent') ?></dd>
			<?php endif; ?>
			
			<?php if (!empty($model->descent)): ?>
				<dt class="col-5 col-sm-4"><?= Yii::t('app', 'Descent') ?></dt>
				<dd class="col-7 col-sm-8"><?= $model->getMetersText('descent') ?></dd>
			<?php endif; ?>
			
			<?php if (!empty($model->min_altitude)): ?>
				<dt class="col-5 col-sm-4"><?= Yii::t('app', 'Lowest point') ?></dt>
				<dd class="col-7 col-sm-8"><?= $model->getAltituteText('min_altitude') ?></dd>
			<?php endif; ?>
			
			<?php if (!empty($model->max_altitude)): ?>
				<dt class="col-5 col-sm-4"><?= Yii::t('app', 'Highest point') ?></dt>
				<dd class="col-7 col-sm-8"><?= $model->getAltituteText('max_altitude') ?></dd>
			<?php endif; ?>
			
  		</dl>
		
	</div>
<?php endif; ?>
