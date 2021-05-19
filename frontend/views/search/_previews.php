<?php if (count($models) < 1): ?>
	<a href="/" class="btn btn-primary">
		<span><?= Yii::t('app', 'To Homepage') ?></span>
	</a>
<?php endif; ?>
	
<div class="row fade-in">
	<?php
	foreach($models as $content)
	{
		echo $this->render('/common/_preview', ['content' => $content]);
	}
	?>
</div>
