<div id="intro">
	 <div class="container">
		<div class="row">
			<div class="col-lg-7">
		   		<div class="label">
		   			<?= $model->label ?>
		   		</div>
				<h1 class="margin-bottom-md">
					<?= $model->title ?>
				</h1>
			  
			  	<div class="margin-bottom-lg ugc">
			  		
			  		<div class="excerpt margin-bottom-md">
						<?= $model->excerpt ?>
					</div>
					
					<?= $this->render('/common/_youtube', ['model' => $model]) ?>
					
					<?= $this->render('/common/_vimeo', ['model' => $model]) ?>
			  		
					<div class="margin-bottom-md">
						<?= $model->description ?>
					</div>
						
				</div>
		   </div>
		   <div class="col-lg-4 offset-lg-1">
				<?= $this->render('/common/_heritageMap', [
					'type' => 'heritage',
					'model' => $content->heritage
				]) ?>
				
				<?= $this->render('_downloads', [
					'models' => $content->downloads
				]) ?>
			</div>
		</div>
	 </div>
</div>
