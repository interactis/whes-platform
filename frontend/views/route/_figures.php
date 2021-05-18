<?php if (!empty($model->catering)): ?>
	<div class="small margin-bottom-md">
		<div class="h3 margin-bottom-sm"><?= Yii::t('app', 'Short Info') ?></div>
		
		<dl class="row">
			
			<?php if (!empty($model->difficulty)): ?>
				<dt class="col-4"><?= Yii::t('app', 'Difficulty') ?></dt>
				<dd class="col-8"><?= $model->difficultyText ?></dd>
			<?php endif; ?>
			
			<?php if (!empty($model->distance_in_km)): ?>
				<dt class="col-4"><?= Yii::t('app', 'Distance') ?></dt>
				<dd class="col-8"><?= $model->distance_in_km ?> km</dd>
			<?php endif; ?>
			
			<?php if (!empty($model->duration_in_min)): ?>
				<dt class="col-4"><?= Yii::t('app', 'Duration') ?></dt>
				<dd class="col-8"><?= $model->durationText ?></dd>
			<?php endif; ?>
			
			
			<dt class="col-4">Starting point</dt>
			<dd class="col-8">Blatten bei Naters, Post, <nobr>1330 m a.s.l.</nobr></dd>
			<dt class="col-4">Endpoint</dt>
			<dd class="col-8">Ried-Mörel, <nobr> 1191 m a.s.l.</nobr></dd>
			
			<dt class="col-4">Ascent</dt>
			<dd class="col-8">238 m</dd>
			<dt class="col-4">Descent</dt>
			<dd class="col-8">378 m</dd>
			<dt class="col-4">Lowest point</dt>
			<dd class="col-8"><nobr> 1190 m a.s.l.</nobr></dd>
			<dt class="col-4">Highest Point</dt>
			<dd class="col-8"><nobr>1452 m a.s.l.</nobr></dd>
  		</dl>
		
		
	</div>
<?php endif; ?>
