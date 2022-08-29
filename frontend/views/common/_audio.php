
<?php
$audio = $model->audio;
if (count($audio) > 0): ?>
	<div class="audio-containter margin-bottom-md">

		<?php foreach ($audio as $audio): ?>
			<audio controls class="audio">
				<source src="<?= $audio->fileUrl ?>" type="audio/mpeg">
				<?= Yii::t('app', 'Your browser does not support audio.') ?>
			</audio>
		<?php endforeach; ?>

	</div>
<?php endif; ?>
