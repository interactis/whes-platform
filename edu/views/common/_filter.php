<?php
use common\models\FlagGroup;

$filterGroups = FlagGroup::getActiveFlagGroups();

$js = "var updateUrl = '/filter/content?heritageId=0&featured=1&limit=default&offset=0';";
if (isset($heritageId))
	$js = "var updateUrl = '/filter/content?heritageId=". $heritageId ."&featured=0&limit=default&offset=0';";

$this->registerJs($js, $this::POS_HEAD);
$filterSet = false;

if (!isset($heritageFilters))
	$heritageFilters = false;
?>

<div id="filter">
	
	<div class="collapse-title last" data-toggle="collapse" data-target="#info-filter" aria-expanded="true" aria-controls="course-filter">
		<div class="container">
			<div class="row title-content">
				<div class="col">
					<div class="h2 thin"><?= Yii::t('app', 'Info Filter') ?></div>
				</div>
			</div>
			<svg class="handle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34.42 58.95"><g data-name="Layer 2"><path fill="none" stroke="#ffffff" stroke-miterlimit="10" stroke-width="7" d="M2.48 2.48l27 27-27 27" /></g></svg>
		</div>
	</div>

	<div class="collapse show" id="info-filter">
		<div class="collapse-wrapper">
			<div class="container filter-groups">
				<div class="row">
					<?php foreach($filterGroups as $group): ?>
						<?= $this->render('_filterGroup', [
							'model' => $group,
							'filters' => $filters,
							'heritageFilters' => $heritageFilters
						]) ?>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<hr />
	</div>
	
	<div class="section-wrapper margin-top-lg"> 
         <div class="container margin-bottom-lg">
         	
         	<div class="margin-bottom-md text-right reset-filter-container <?= (count($filters) < 1 ? 'hidden' : '') ?>">
         		<a href="#" class="reset-filter"><i class="fa fa-undo"></i> <?= Yii::t('app', 'Reset filter') ?></a>	
         	</div>
         	
         	<div id="info">
           		<?= $this->render('_previews', ['models' => $content]) ?>
           	</div>
         </div>
	</div>
</div>
