<?php
$stages = $model->stages;
if ($stages && $stages['currentChild']): ?>
	<div class="thin margin-bottom-md">
		<i class="fa fa-flag"></i>&nbsp;&nbsp;
		<?php
		$link = '<a href="/'. Yii::t('app', 'route') .'/'. $stages['parentRoute']->slug .'">'. $stages['parentRoute']->title .'</a>';
		
		echo Yii::t('app', 'Stage {i} of: {link}', [
			'i' => $stages['currentChild']['i'],
			'link' => $link
		]);
		?>
	</div>
<?php endif; ?>
