<?php
$js = "var updateUrl = '/site/content-update';";
$this->registerJs($js, $this::POS_HEAD);
$filterSet = false;
?>

<div class="section" id="filter">
	
	<div class="collapse-title last collapsed" data-toggle="collapse" data-target="#info-filter" aria-expanded="true" aria-controls="course-filter">
		<div class="container">
			<div class="row title-content">
				<div class="col">
					<div class="h2 thin"><?= Yii::t('app', 'Info Filter') ?></div>
				</div>
			</div>
			<svg class="handle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34.42 58.95"><g data-name="Layer 2"><path fill="none" stroke="#ffffff" stroke-miterlimit="10" stroke-width="7" d="M2.48 2.48l27 27-27 27" /></g></svg>
		</div>
	</div>

	<div class="collapse" id="info-filter">
		<div class="container">
			<br /><br />
			<div class="h4 margin-bottom">Under Construction</div>
			<p class="small">Hier erscheinen in Kürze die Filter.</p>
			<br /><br />
		</div>
		<hr />
	</div>
	
	<div class="section-wrapper margin-top-lg"> 
         <div id="info" class="container margin-bottom-lg">
            <?= $this->render('_previews.php', ['models' => $content]) ?>
         </div>
	</div>
</div>
