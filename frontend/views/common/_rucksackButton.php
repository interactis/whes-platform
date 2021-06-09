<?php
$js = "
	$(document).on('click', '.rucksack-btn', function(e) {
		e.preventDefault();
		var btn = $(this);
		var contentId = btn.attr('content-id');
		
		//var counter = $('#bookmark-count');
		//var count = parseInt(counter.text());
	
		if (btn.hasClass('active') === true) {
			btn.removeClass('active');
			// count = count-1;
		}
		else {
			btn.addClass('active');
			// count = count+1;
		}
		
		$.ajax({
			type: 'GET',
			url: '/rucksack/toggle',
			data: {id: contentId},
			success: function(data) {
				
				/*
				var bookmarkCount = $('#bookmark-count');
		
				if (count == 0) {
					bookmarkCount.addClass('hidden');
				}
				else {
					bookmarkCount.removeClass('hidden');
				}
		
				bookmarkCount.text(('0' + count).slice(-2));
				*/
			}
		});
	});
";

$this->registerJs($js, $this::POS_READY);


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