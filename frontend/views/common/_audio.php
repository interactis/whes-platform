
<?php
$audio = $model->audio;
if (count($audio) > 0): ?>
	<div class="audio-containter margin-bottom-md">

		<?php foreach ($audio as $audio): ?>
			
			<audio controls>
				<source src="<?= $audio->fileUrl ?>" type="audio/mpeg">
				<?= Yii::t('app', 'Your browser does not support the audio tag.') ?>
			</audio> 
			
			
		<?php endforeach; ?>

	</div>
<?php endif; ?>
