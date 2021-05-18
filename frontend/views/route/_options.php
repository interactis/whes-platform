<?php if (!empty($model->options)): ?>
	<div class="small margin-bottom-md">
		<div class="h3 margin-bottom-sm"><?= Yii::t('app', 'Alternative Routes') ?></div>
		<?= $model->options ?>
	</div>
<?php endif; ?>
