<?php
use yii\helpers\Html;

if (!isset($btnText)) {
	$btnText = Yii::t('app', 'Save');
	$icon = '<span class="glyphicon glyphicon-floppy-disk"></span>';
}

if (!isset($viewUrl)) {
	$viewUrl = false;
}

if (!isset($nav)) {
	$nav = false;
}

if (!isset($showLangSwitch))
	$showLangSwitch = false;
?>

<div class="col-md-2 col-lg-4">
	<div class="form-group fixed">
		<?= $form->errorSummary($model); ?>
		<?= Html::submitButton($icon .'&nbsp;&nbsp;'. $btnText, ['class' => 'btn btn-success']) ?>&nbsp;
		
		<?php
		if ($viewUrl && !$model->isNewRecord)
		{
			$user = Yii::$app->user->identity;
			echo Html::a(Yii::t('app', '<span class="glyphicon glyphicon-eye-open"></span>&nbsp;&nbsp;View'), $viewUrl, ['class' => 'btn btn-default', 'target' => '_blank']);
		}
		?>
		
		<?php if ($nav): ?>
			<div style="margin-top: 24px;">
				<label><?= Yii::t('app', 'Quick access') ?>:</label>
				<ul class="list-unstyled">
					<?php foreach($nav as $nav): ?>
						<li><a href="#<?= $nav['slug'] ?>" class="smooth-scroll"><?= $nav['title'] ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
		
		<?php if ($showLangSwitch): ?>
			<div style="margin-top: 24px;">
				<label><?= Yii::t('app', 'Switch all tabs') ?>:</label>
				<p>
					<a class="switch-tabs-de" href="#">DE</a> | 
					<a class="switch-tabs-en" href="#">EN</a> | 
					<a class="switch-tabs-fr" href="#">FR</a> | 
					<a class="switch-tabs-it" href="#">IT</a>
				</p>
			</div>
		<?php endif; ?>
		
	</div>
</div>
