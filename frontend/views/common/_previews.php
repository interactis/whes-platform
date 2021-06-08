<?php if (count($models) < 1): ?>
	<div class="h4 margin-bottom-lg"><?= Yii::t('app', 'No results found.') ?> <?= Yii::t('app', 'Please select other filters.') ?></div>
<?php endif; ?>

<div class="row fade-in">
	<?php
	foreach($models as $content)
	{
		echo $this->render('/common/_preview', ['content' => $content]);
	}
	?>
</div>
