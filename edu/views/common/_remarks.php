<?php if (!empty($model->remarks)): ?>
	<div class="small margin-bottom-md">
		<div class="h3 margin-bottom-sm"><?= Yii::t('app', 'Remarks') ?></div>
		<?= $model->remarks ?>
	</div>
<?php endif; ?>
