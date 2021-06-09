<?php
$this->title = Yii::t('app', 'Rucksack');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="rucksack-view container margin-top-lg">
	<div class="h1 margin-bottom-lg">
		<?php
		$count = count($models);
		if ($count < 1)
		{
			echo Yii::t('app', 'No results found.');
			$showButtons = true;
		}
		else
		{
			echo Yii::t('app', 'My Collection');
		}
		?>
	</div>
	
	<?php if (!empty($q)): ?>
		<p class="lead margin-bottom-lg"><?= Yii::t('app', 'Search term') ?>: <i><?= $q ?></i></p>
	<?php endif; ?>
	
	<?= $this->render('_previews.php', ['models' => $models]) ?>
</div>
