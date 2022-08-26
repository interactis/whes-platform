<?php
$count = count($models);

$title = Yii::t('app', 'Download');
if ($count > 1)
	$title = Yii::t('app', 'Downloads');

if ($count > 0): ?>
	<div class="card margin-bottom-md">
		<div class="card-header dark">
			<div class="h4"><?= $title ?></div>
		</div>
		<div class="card-body">
			<ul class="list-unstyled">
				<?php foreach($models as $model): ?>
					<li>
				
						
					
						
						
						<div class="h4">
							<a href="#">
								<?= $model->title ?>
							</a>
						</div>
						<p class="margin-bottom-md"><?= $model->description ?></p>
						
						<a class="btn btn-primary btn-sm" href="#">
							<i class="fa fa-download"></i>&nbsp;<?= Yii::t('app', 'Download') ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
<?php endif ?>
