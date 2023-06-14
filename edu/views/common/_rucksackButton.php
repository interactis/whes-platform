<?php
$class = "small";
$showActionText = false;
if (isset($largeBtn) && $largeBtn)
{
	$class = "";
	$showActionText = true;
}
?>

<a href="#" class="action-btn rucksack-btn <?= ($model->inRucksack ? 'active' : '') ?> <?= $class ?>" content-id="<?= $model->id ?>" title="<?= Yii::t('app', 'Bookmark') ?>">
	<?= $this->render('/layouts/_svg/_rucksackCircle') ?>
	<?php if ($showActionText): ?>
		<div class="action-text"><?= Yii::t('app', 'Bookmark') ?></div>
	<?php endif; ?>
</a>