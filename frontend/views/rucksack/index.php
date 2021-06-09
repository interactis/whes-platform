<?php
$this->title = Yii::t('app', 'Rucksack');
$this->params['breadcrumbs'][] = $this->title;

$count = count($models);
?>

<div class="rucksack-view container margin-top-lg margin-bottom-lg">
	
	<div class="margin-bottom-md">
		<?php if ($count == 0): ?>
			<div class="row">
				<div class="col-md-10 col-lg-7 col-xl-6">
					<div class="h1 margin-bottom-md">
						<?= Yii::t('app', 'Your collection is still empty.') ?>
					</div>
					<p class="lead"><?= Yii::t('app', 'Click on the rucksack icon to collect what you like and get personalized trip recommendations here.') ?></p>
				</div>
			</div>
		<?php else: ?>
			<div class="h1 margin-bottom-lg">
				<?= Yii::t('app', 'My Collection') ?>
			</div>
		<?php endif; ?>
	</div>
	
	<?= $this->render('/common/_previews', ['models' => $models, 'isFilter' => false]) ?>
</div>
