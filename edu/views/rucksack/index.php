<?php
$this->title = Yii::t('app', 'Rucksack');
$this->params['breadcrumbs'][] = $this->title;

$count = count($models);
?>

<div class="rucksack-view margin-top-lg margin-bottom-lg">
	
	<div class="container margin-bottom-md">
		<?php if ($count == 0): ?>
			<div class="row">
				<div class="col-md-10 col-lg-7 col-xl-6">
					<div class="h1 margin-bottom-md">
						<?= Yii::t('app', 'Your collection is still empty.') ?>
					</div>
					<p class="lead"><?= Yii::t('app', 'Click on the rucksack icon to bookmark what you like.') ?></p>
				</div>
			</div>
		<?php else: ?>
			<div class="h1 margin-bottom-lg">
				<?= Yii::t('app', 'My Collection') ?>
			</div>
			
			<?= $this->render('/common/_previews', ['models' => $models, 'isFilter' => false]) ?>
			
		<?php endif; ?>
	</div>
	
	<?= $this->render('/common/_relatedContent', ['related' => $related]) ?>
		
</div>
