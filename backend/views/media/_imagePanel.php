<?php
use yii\helpers\Html;
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3>
			<?= Yii::t('app', 'Image') .' '. $count  ?>
			<p class="pull-right">
				<?= Html::a(Yii::t('app', '<span class="glyphicon glyphicon-pencil"></span>'), ['update-'. $type .'-media', 'id' => $model->id], ['class' => 'btn btn-primary btn-xs', 'title' => 'update group']) ?>
				<?= Html::a(Yii::t('app', '<span class="glyphicon glyphicon-trash"></span>'), ['delete', 'id' => $model->id], [
					'class' => 'btn btn-danger btn-xs',
					'title' => 'delete group',
					'data-confirm' => Yii::t('app', 'Are you sure you want to delete this image?'),
					'data-method'  => 'post'
				]) ?>
			</p>
		</h3>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-4">
				<?= $model->getImageHtml(600, 'img-thumbnail', 'Media image') ?>
			</div>
			<div class="col-md-8">
				<div class="h4"><?= $model->title ?></div>
				<?= $model->description ?>
				
				<?php
				if (!empty($model->copyright))
					echo '<p>&copy; '. $model->copyright .'<p>';
				?>
				
				<?php
				if (!empty($model->animate))
					echo '<p class="small text-info"><span class="glyphicon glyphicon-ok-circle"></span> Animated</p>';
				?>
			</div>
		</div>
	</div>
</div>
