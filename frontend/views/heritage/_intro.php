<div id="intro">
	 <div class="container">
		<div class="row">
			<div class="col-md-7 order-md-2 offset-lg-1">
		   		<div class="label"><?= Yii::t('app', 'UNESCO World Heritage') ?></div>
				<h1 class="margin-bottom-md">
					<?= $model->name ?>
				</h1>
				
				<div class="margin-bottom-lg">
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
				<div class="margin-bottom-lg text-center">
					<a href="/map">
						<img src="/img/layout/map.svg" class="img-fluid w-100" alt="<?= Yii::t('app', 'Map') ?>">
					</a>
					<a href="/map">
						<i class="fa fa-map-marker"></i> 
						<?= Yii::t('app', 'Show map') ?>
					</a>
				</div>
			</div>
		</div>
	 </div>
</div>
