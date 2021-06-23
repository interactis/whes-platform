<?php if (!empty($model->options)): ?>
	<div class="small margin-bottom-md">
		<div class="h3 margin-bottom-sm"><?= Yii::t('app', 'Alternative routes') ?></div>
		<?= $model->options ?>
	</div>
<?php endif; ?>
