<div id="intro">
	 <div class="container">
		<div class="row">
			<div class="col-md-7">
		   		<div class="label">
		   			<?= Yii::t('app', 'Point of Interest') ?><br />
		   			<em><?= $heritage->short_name ?></em>
		   		</div>
				<h1 class="margin-bottom-md">
					<?= $model->title ?>
				</h1>
			  
			  	<div class="margin-bottom-lg">
					<div class="margin-bottom-md">
						<?= $model->description ?>
					</div>
				
					<?php if (!empty($model->remarks)): ?>
						<div class="small margin-bottom-md">
							<div class="h3 margin-bottom-sm"><?= Yii::t('app', 'Remarks') ?></div>
							<?= $model->remarks ?>
						</div>
					<?php endif; ?>
				</div>
		   </div>
		   <div class="col-md-5 col-lg-4 offset-lg-1">
				
				<?= Yii::$app->controller->renderPartial('//common/_heritageMap') ?>
				
				<?= $this->render('_trip.php', ['model' => $model]) ?>
				
			</div>
		</div>
	 </div>
</div>
