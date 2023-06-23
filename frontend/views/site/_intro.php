<div id="intro">
	<div class="container">
		<div class="row">
		   <div class="col-md-9 col-lg-7 col-xl-6">
				<h1 class="margin-bottom-md">
					<?= $model->title ?>
				</h2>
				<div class="margin-bottom-md">
					<?= $model->description ?>
				</div>
			</div>
		</div>
	</div>
	<?php
	if (Yii::$app->params['frontendType'] == 'visitor')
		echo $this->render('_overviewMap');
	?>
</div>
