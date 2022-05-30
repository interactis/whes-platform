<div id="intro">
	 <div class="container">
		<div class="row">
			<div class="col-md-7 order-md-2 offset-lg-1">
		   		<div class="label"><?= $model->getTypeText() ?></div>
				<h1 class="margin-bottom-md">
					<?= $model->name ?>
				</h1>
				
				<div class="margin-bottom-lg ugc">
					<div class="margin-bottom-md">
						<?= $model->description ?>
					</div>
				
					<?php if (!empty($model->link_url) && !empty($model->link_text)): ?>
						<div class="margin-bottom-md">
							<a href="<?= $model->link_url ?>">
								<i class="fa fa-chevron-right"></i>
								<?= $model->link_text ?>
							</a>
						</div>
					<?php endif; ?>
				</div>
		   </div>
			<div class="col-md-5 col-lg-4">
				<?= $this->render('/common/_heritageMap', [
					'type' => 'heritage',
					'model' => $model
				]) ?>
			</div>
		</div>
	 </div>
</div>
