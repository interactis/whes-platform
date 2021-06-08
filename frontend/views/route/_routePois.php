<?php if ($pois = $model->routePois): ?>
	<div id="related" class="container margin-bottom-lg">
		<div class="h2 margin-bottom-md">
			<?= Yii::t('app', 'Along this route:') ?>
		</div>
		
		<div class="row">
			<?php foreach($pois as $poi): ?>				
				<?= $this->render('/common/_preview', [
					'model' => $poi,
					'content' => $poi->content
				]) ?>
			<?php endforeach; ?>
		</div>
	</div>
<?php else: ?>
	<?= $this->render('/common/_relatedContent', ['model' => $content]) ?>
<?php endif; ?>
