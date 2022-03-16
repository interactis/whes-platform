<?php
$user = Yii::$app->user->identity;
?>

<?php if ($user->isAdmin()): ?>
	<div id="quality-control" class="panel panel-default">
		<div class="panel-heading">
			<h3>Quality Control</h3>
		</div>
		<div class="panel-body">
			
			<?= $form->field($contentModel, 'imported')->checkbox() ?>
			
			<?= $form->field($contentModel, 'approved')->checkbox() ?>
			
			<?= $form->field($contentModel, 'edited')->checkbox() ?>
		
		</div>
	</div>
<?php endif; ?>
