<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\PoiTranslation;
use backend\components\poiwidget\PoiWidget;

$translations = $model->poiTranslations;
$translationModel = new PoiTranslation();

$nav = [
	[
		'slug' => 'info',
		'title' => 'Info'
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
		'slug' => 'relations',
		'title' => 'Relations'
	],
	[
		'slug' => 'visibility',
		'title' => 'Visibility'
	]
];

$viewUrl = false;
if (!$model->isNewRecord && $model->content->published)
	$viewUrl = Yii::$app->params['frontendUrl'] .'poi/'. $model->slug;
?>

<div class="poi-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="row">
    	<div class="col-md-10 col-lg-8">
    	
			<div id="info" class="panel panel-default">
				<div class="panel-heading">
					<h3>Info</h3>
				</div>
				<div class="panel-body">

					<?= $this->render('/translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'title',
						'translations' => $translations,
						'translationModel' => $translationModel
					]); ?>
					
					<?= $this->render('/translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'description',
						'translations' => $translations,
						'translationModel' => $translationModel,
						'isWysiwyg' => true,
						'height' => 400
					]); ?>
					
					<?= $this->render('/translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'youtube_id',
						'translations' => $translations,
						'translationModel' => $translationModel,
						'hint' => Yii::t('app', 'Use the last section of the YouTube video link right after <code>watch?v=</code><br />Example: <strong>www.youtube.com/watch?v=<code>uU4c2UX5Lz8</code></strong>')
					]); ?>
					
					<?= $this->render('/translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'remarks',
						'translations' => $translations,
						'translationModel' => $translationModel,
						'isWysiwyg' => true
					]); ?>
				
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
				
					<?= $this->render('/translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'directions',
						'translations' => $translations,
						'translationModel' => $translationModel,
						'isWysiwyg' => true
					]); ?>
				
				</div>
			</div>
			
			<div id="geo" class="panel panel-default">
				<div class="panel-heading">
					<h3>Geo</h3>
				</div>
				<div class="panel-body">
				
					<div class="hint-block margin-bottom-sm"><?= Yii::t('app', 'Click on the map to position the point of interest') ?>:</div>
					
					<?= PoiWidget::widget(['model' => $model, 'attribute' => 'geom', 'value' => $model->geom, 'created' => $model->isNewRecord]) ?>
				</div>
			</div>
			
			<?= $this->render('/common/_relationsForm', [
				'model' => $model,
				'contentModel' => $contentModel,
				'form' => $form
			]) ?>
			
			<div id="visibility" class="panel panel-default">
				<div class="panel-heading">
					<h3>Visibility</h3>
				</div>
				<div class="panel-body">
					<?= $form->field($contentModel, 'priority')->dropDownList($model->priorities)
						->hint(Yii::t("app", "Influences where the POI appears in filter and search results.")) ?>
					
					<?= $form->field($contentModel, 'published')->checkbox() ?>
					
					<?= $form->field($contentModel, 'hidden')->checkbox()
						->hint(Yii::t("app", "If hidden, the POI won't be shown in overviews but it will still be available via direct link.")) ?>
				</div>
				
			</div>
			
		</div>
		
		<?= $this->render('/common/_saveColumn', [
			'form' => $form,
			'model' => $model,
			'showLangSwitch' => true,
			'viewUrl' => $viewUrl,
			'nav' => $nav
		]) ?>
   		
   	</div>

    <?php ActiveForm::end(); ?>

</div>
