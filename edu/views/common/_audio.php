<?php
$audio = $model->audio;
if (count($audio) > 0): ?>
	<div class="audio-containter margin-bottom-md">
		<?php foreach ($audio as $i => $audio): ?>
			<div class="margin-bottom-md">
				<?php if (!empty($audio->title)): ?>
					<h2><?= $audio->title ?></h2>
				<?php endif; ?>
			
				<audio id="audio-<?= $i ?>" controls class="audio margin-bottom-sm">
					<source src="<?= $audio->fileUrl ?>" type="audio/mpeg">
					<?= Yii::t('app', 'Your browser does not support audio.') ?>
				</audio>
			
				<?php if (!empty($audio->description)): ?>
					<div class="small">
						<?= $audio->description ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
