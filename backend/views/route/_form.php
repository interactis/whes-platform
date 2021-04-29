<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\RouteTranslation;
use common\models\Heritage;

$translations = $model->routeTranslations;
$translationModel = new RouteTranslation();

$nav = [
	[
		'slug' => 'info',
		'title' => 'Info'
	],
	[
		'slug' => 'key-figures',
		'title' => 'Key Figures'
	],
	[
		'slug' => 'sbb',
		'title' => 'SBB'
	],
	[
		'slug' => 'geo',
		'title' => 'Geo'
	],
	[
		'slug' => 'visibility',
		'title' => 'Visibility'
	]
];

$viewUrl = false;
if (!$model->isNewRecord)
	$viewUrl = Yii::$app->params['frontendUrl'] .'route/'. $model->slug;

$tagValue = [];
if (isset($model->content->contentTags))
	$tagValue = ArrayHelper::map($model->content->contentTags, 'tag_id', 'tag_id');

$user = Yii::$app->user->identity;
?>

<div class="route-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="row">
    	<div class="col-md-10 col-lg-8">
    	
			<div id="info" class="panel panel-default">
				<div class="panel-heading">
					<h3>Info</h3>
				</div>
				<div class="panel-body">

					<?= Yii::$app->controller->renderPartial('//translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'title',
						'translations' => $translations,
						'translationModel' => $translationModel
					]); ?>
					
					<?= Yii::$app->controller->renderPartial('//translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'youtube_id',
						'translations' => $translations,
						'translationModel' => $translationModel
					]); ?>
					
					<?= Yii::$app->controller->renderPartial('//translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'description',
						'translations' => $translations,
						'translationModel' => $translationModel,
						'isWysiwyg' => true,
						'height' => 400
					]); ?>
					
					<?= Yii::$app->controller->renderPartial('//translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'catering',
						'translations' => $translations,
						'translationModel' => $translationModel,
						'isWysiwyg' => true
					]); ?>
					
					<?= Yii::$app->controller->renderPartial('//translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'options',
						'translations' => $translations,
						'translationModel' => $translationModel,
						'isWysiwyg' => true
					]); ?>
					
					<?= Yii::$app->controller->renderPartial('//translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'remarks',
						'translations' => $translations,
						'translationModel' => $translationModel,
						'isWysiwyg' => true
					]); ?>
					
					<?= $form->field($model, 'difficulty')->dropDownList($model->difficulties) ?>	
				
				</div>
			</div>
			
			<div id="key-figures" class="panel panel-default">
				<div class="panel-heading">
					<h3>Key Figures</h3>
				</div>
				<div class="panel-body">
					<?= $form->field($model, 'distance_in_km') ?>
					
					<?= $form->field($model, 'duration_in_min') ?>
					
					<?= $form->field($model, 'min_altitude') ?>
					
					<?= $form->field($model, 'max_altitude') ?>
					
					<?= $form->field($model, 'start_altitude') ?>
					
					<?= $form->field($model, 'end_altitude') ?>
					
					<?= $form->field($model, 'ascent') ?>
					
					<?= $form->field($model, 'descent') ?>
				</div>
			</div>
			
			<div id="sbb" class="panel panel-default">
				<div class="panel-heading">
					<h3>SBB</h3>
				</div>
				<div class="panel-body">
					<?= $form->field($model, 'arrival_station') ?>
					
					<?= $form->field($model, 'arrival_url')
						->hint(Yii::t('app', 'How to deep link to SBB timetable:') .' <a href="/downloads/Deep_Linking_SBB_Fahrplan.pdf" target="_blank"><span class="glyphicon glyphicon-download"></span> SBB Deep Linking</a>') ?>
					
					<?= $form->field($model, 'departure_station') ?>
					
					<?= $form->field($model, 'departure_url')
						->hint(Yii::t('app', 'How to deep link to SBB timetable:') .' <a href="/downloads/Deep_Linking_SBB_Fahrplan.pdf" target="_blank"><span class="glyphicon glyphicon-download"></span> SBB Deep Linking</a>') ?>
				</div>
			</div>
			
			<div id="geo" class="panel panel-default">
				<div class="panel-heading">
					<h3>Geo</h3>
				</div>
				<div class="panel-body">
					
				</div>
			</div>
			
			<div id="visibility" class="panel panel-default">
				<div class="panel-heading">
					<h3>Visibility</h3>
				</div>
				<div class="panel-body">
					<?php
    				if ($user->isAdmin())
					{
						echo $form->field($contentModel, 'heritage_id')->dropDownList(
							Heritage::getHeritages(),
							['prompt' => Yii::t('app', 'Please select')]
						);
					}
					?>
					
					<?= Yii::$app->controller->renderPartial('//common/_tagSelect', [
						'model' => $model,
						'tagValue' => $tagValue
					]); ?>
					
					<?= $form->field($contentModel, 'priority')->dropDownList($model->priorities)
						->hint(Yii::t("app", "Influences where the route appears in filter and search results.")) ?>
					
					<?= $form->field($contentModel, 'published')->checkbox() ?>
					
					<?= $form->field($contentModel, 'hidden')->checkbox()
						->hint(Yii::t("app", "If hidden, the route won't be shown in overviews but it will still be available via direct link.")) ?>
				</div>
				
			</div>
			
		</div>
		
		<?= Yii::$app->controller->renderPartial('//common/_saveColumn', [
			'form' => $form,
			'model' => $model,
			'showLangSwitch' => true,
			'viewUrl' => $viewUrl,
			'nav' => $nav
		]) ?>
   		
   	</div>

    <?php ActiveForm::end(); ?>

</div>
