<?php if (!empty($model->schedule)): ?>
	<div class="small margin-bottom-md">
		<div class="h3 margin-bottom-sm"><?= Yii::t('app', 'Event schedule') ?></div>
		<?= $model->schedule ?>
	</div>
<?php endif; ?>
