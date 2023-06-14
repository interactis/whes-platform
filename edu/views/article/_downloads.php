<?php
$count = count($models);

$title = Yii::t('app', 'Download');
if ($count > 1)
	$title = Yii::t('app', 'Downloads');

if ($count > 0): ?>
	<div class="card max-height margin-bottom-lg">
		<div class="card-header dark">
			<div class="h4"><?= $title ?></div>
		</div>
		<div class="card-body">
			<ul class="list-unstyled">
				<?php foreach($models as $model):
					$url = $model->fileUrl
					?>
					<li>
						<a class="btn btn-primary btn-sm pull-right" target="_blank" href="<?= $url ?>">
							<i class="fa fa-download"></i>&nbsp;<?= Yii::t('app', 'Download') ?>
						</a>
						<div class="h4 margin-bottom">
							<a target="_blank" href="<?= $url ?>">
								<?= $model->title ?>
							</a>
						</div>
						<p><?= $model->description ?></p>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
<?php endif ?>
