<?php
$js = "var updateUrl = '/site/content-update';";
$this->registerJs($js, $this::POS_HEAD);
$filterSet = false;
?>

<div class="section" id="filter">
	
	<div class="collapse-title last collapsed" data-toggle="collapse" data-target="#info-filter" aria-expanded="true" aria-controls="course-filter">
		<div class="container">
			<div class="row title-content">
				<div class="col-lg-12">
					<div class="h2 thin"><?= Yii::t('app', 'Info Filter') ?></div>
				</div>
			</div>
			<svg class="handle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34.42 58.95"><g data-name="Layer 2"><path fill="none" stroke="#b51f2a" stroke-miterlimit="10" stroke-width="7" d="M2.48 2.48l27 27-27 27" data-name="Layer 1"/></g></svg>
		</div>
	</div>

	<div class="collapse" id="info-filter">
		Test
	</div>
	
	<div class="section-wrapper margin-top-lg"> 
         <div id="info" class="container margin-bottom-lg">
            <?php // $this->render('_content.php', ['models' => $contents]) ?>
         </div>
	</div>
</div>
