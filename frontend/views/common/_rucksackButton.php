<?php
$class = "small";
$showActionText = false;
if (isset($largeBtn) && $largeBtn)
{
	$class = "";
	$showActionText = true;
}
?>

<a href="#" class="action-btn bookmark-btn text-center <?= $class ?>" title="<?= Yii::t('app', 'Bookmark') ?>">
	<?= $this->render('/layouts/_svg/_rucksackCircle') ?>
	<?php if ($showActionText): ?>
		<div class="action-text"><?= Yii::t('app', 'Bookmark') ?></div>
	<?php endif; ?>
</a>