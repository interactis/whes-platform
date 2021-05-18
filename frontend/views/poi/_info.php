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
				
					<?= $this->render('/common/_remarks', ['model' => $model]) ?>
					
					<?= $this->render('/common/_supplier', ['model' => $content]) ?>
					
				</div>
		   </div>
		   <div class="col-md-5 col-lg-4 offset-lg-1">
				
				<?= $this->render('/common/_heritageMap') ?>
				
				<?= $this->render('_trip.php', ['model' => $model]) ?>
				
			</div>
		</div>
	 </div>
</div>
