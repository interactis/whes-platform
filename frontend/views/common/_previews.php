<?php
if (!isset($isFilter))
	$isFilter = true;
	
if (isset($totalContent))
	echo '<div id="total-filter-content" class="hidden">'. $totalContent .'</div>';
?>

<?php if ($isFilter): ?>

	<?php if (count($models) < 1): ?>
		<div class="h4 margin-bottom-lg"><?= Yii::t('app', 'No results found.') ?> <?= Yii::t('app', 'Please select other filters.') ?></div>
	<?php endif; ?>
	
<?php else: ?>

	<?php if (count($models) < 1): ?>
		<a href="/" class="btn btn-primary">
			<span><?= Yii::t('app', 'To the homepage') ?></span>
		</a>
	<?php endif; ?>
	
<?php endif; ?>

<div class="row fade-in">
	<?php
	foreach($models as $content)
	{
		echo $this->render('/common/_preview', ['content' => $content]);
	}
	?>
</div>
