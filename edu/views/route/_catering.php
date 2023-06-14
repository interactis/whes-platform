<?php if (!empty($model->catering)): ?>
	<div class="small margin-bottom-md">
		<div class="h3 margin-bottom-sm"><?= Yii::t('app', 'Restaurants') ?></div>
		<?= $model->catering ?>
	</div>
<?php endif; ?>
