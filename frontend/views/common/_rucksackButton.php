<?php
/*
$js = "
	$(document).on('click', '.rucksack-btn', function(e) {
		e.preventDefault();
		var btn = $(this);
		var contentId = btn.attr('content-id');
	
		if (btn.hasClass('active') === true) {
			btn.removeClass('active');
		}
		else {
			btn.addClass('active');
		}
		
		$.ajax({
			type: 'GET',
			url: '/rucksack/toggle',
			data: {id: contentId},
			success: function(data) {
			}
		});
	});
";

$this->registerJs($js, $this::POS_READY);
*/

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