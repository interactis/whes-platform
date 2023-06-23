<?php
$class = "small";
$showActionText = false;
if (isset($largeBtn) && $largeBtn)
{
	$class = "";
	$showActionText = true;
}

$iconPath = '/layouts/_svg/visitor/';
if (Yii::$app->params['frontendType'] == 'edu')
	$iconPath = '/layouts/_svg/edu/';
?>

<a href="#" class="action-btn rucksack-btn <?= ($model->inRucksack ? 'active' : '') ?> <?= $class ?>" content-id="<?= $model->id ?>" title="<?= Yii::t('app', 'Bookmark') ?>">
	<?= $this->render($iconPath .'_rucksackCircle') ?>
	<?php if ($showActionText): ?>
		<div class="action-text"><?= Yii::t('app', 'Bookmark') ?></div>
	<?php endif; ?>
</a>