<?php if (!empty($model->youtube_id)): ?>
	<div class="margin-bottom-md">
		<iframe class="youtube-iframe" src="https://www.youtube.com/embed/<?= $model->youtube_id ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</div>
<?php endif; ?>