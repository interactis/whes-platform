<?php if (!empty($model->vimeo_id)): ?>
	<div class="margin-bottom-md">
		<iframe class="vimeo-iframe" src="https://player.vimeo.com/video/<?= $model->vimeo_id ?>" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
	</div>
<?php endif; ?>