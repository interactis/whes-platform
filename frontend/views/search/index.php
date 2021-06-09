<?php
$this->title = Yii::t('app', 'Search');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="search-view container margin-top-lg margin-bottom-lg">
	<div class="h1 margin-bottom">
		<?php
		$count = count($models);
		if ($count < 1)
		{
			echo Yii::t('app', 'No results found.');
		}
		elseif ($count == 1)
		{
			echo Yii::t('app', '1 result found.');
		}
		else
			echo Yii::t('app', '{count} results found.', ['count' => $count]);
		?>
	</div>
	
	<?php if (!empty($q)): ?>
		<p class="lead margin-bottom-lg"><?= Yii::t('app', 'Search term') ?>: <i><?= $q ?></i></p>
	<?php endif; ?>
	
	<?= $this->render('/common/_previews', ['models' => $models, 'isFilter' => false]) ?>
</div>
