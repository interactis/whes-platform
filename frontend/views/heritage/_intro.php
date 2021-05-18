<div id="intro">
	 <div class="container">
		<div class="row">
			<div class="col-md-5 col-lg-4">
				<div class="margin-bottom-lg text-center">
					<a href="#">
						<img src="/img/layout/_construction/we-map.png" class="img-fluid w-100" alt="<?= Yii::t('app', 'Map') ?>">
					</a>
					<a href="#">
						<i class="fa fa-map-marker"></i> 
						<?= Yii::t('app', 'Show map') ?>
					</a>
				</div>
			</div>
			<div class="col-md-7 offset-lg-1">
		   		<div class="label"><?= Yii::t('app', 'UNESCO World Heritage') ?></div>
				<h1 class="margin-bottom-md">
					<?= $model->name ?>
				</h1>
				<div class="margin-bottom-lg ">
					<?= $model->description ?>
				</div>
		   </div>
		</div>
	 </div>
</div>
