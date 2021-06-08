<?php if ($related = $model->relatedContent): ?>
	<div id="related">
		 <div class="container margin-bottom-lg">
			
			<div class="h2 margin-bottom-md">
				<?= Yii::t('app', 'This might also interest you:') ?>
			</div>
			
			<div class="row">
				<?php foreach($related as $rel): ?>				
					<?= $this->render('_preview', [
						'content' => $rel->content
					]) ?>
				<?php endforeach; ?>
			</div>
			  
		 </div>
	</div>
<?php endif; ?>