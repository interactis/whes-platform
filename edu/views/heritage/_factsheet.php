<?php if (isset($model->profileItems[0]) && !empty($model->profileItems[0]->title)): ?>
	<div class="card margin-bottom-md">
		<div class="card-header">
			<div class="h4"><?= Yii::t('app', 'Factsheet') ?></div>
		</div>
		<div class="card-body">
			<div class="body-content small">
				<?php foreach($model->profileItems as $item): ?>
					<div class="h5"><?= $item->title ?></div>
					<?= $item->description ?>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
<?php endif ?>
