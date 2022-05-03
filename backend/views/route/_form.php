<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\RouteTranslation;
use kartik\file\FileInput;

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
		'slug' => 'relations',
		'title' => 'Relations'
	],
	[
		'slug' => 'visibility',
		'title' => 'Visibility'
	]
];

$user = Yii::$app->user->identity;
if ($user->isAdmin()) {
	$nav[] = [
		'slug' => 'quality-control',
		'title' => 'Quality Control'
	];
}

$viewUrl = false;
if (!$model->isNewRecord && $model->content->published && !$model->content->archive)
	$viewUrl = Yii::$app->params['frontendUrl'] .'route/'. $model->slug;
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

					<?= $this->render('/translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'title',
						'translations' => $translations,
						'translationModel' => $translationModel
					]); ?>
					
					<div class="<?= ($model->isNewRecord ? 'hidden' : '') ?>">
						<?= Yii::$app->controller->renderPartial('//translation/field', [
							'model' => $model,
							'form' => $form,
							'field' => 'slug',
							'translations' => $translations,
							'translationModel' => $translationModel,
							'hint' => Yii::t('app', 'The slug is used in the URL. Example: <strong>https://ourheritage.ch/route/<code>this-is-a-slug</code></strong>')
						]); ?>
					</div>
					
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
						'hint' => Yii::t('app', 'Use the last section of the YouTube video link right after <code>watch?v=</code><br />Example: <strong>https://www.youtube.com/watch?v=<code>uU4c2UX5Lz8</code></strong>')
					]); ?>
					
					<?= $this->render('/translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'vimeo_id',
						'translations' => $translations,
						'translationModel' => $translationModel,
						'hint' => Yii::t('app', 'Use the last section of the Vimeo video link right after <code>https://vimeo.com/</code><br />Example: <strong>https://vimeo.com/<code>73556553</code></strong>')
					]); ?>
					
					<?= $this->render('/translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'catering',
						'translations' => $translations,
						'translationModel' => $translationModel,
						'isWysiwyg' => true
					]); ?>
					
					<?= $this->render('/translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'options',
						'translations' => $translations,
						'translationModel' => $translationModel,
						'isWysiwyg' => true
					]); ?>
					
					<?= $this->render('/translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'remarks',
						'translations' => $translations,
						'translationModel' => $translationModel,
						'isWysiwyg' => true
					]); ?>
					
					<?= $form->field($model, 'difficulty')->dropDownList(
						$model->getDifficulties(true),
						['prompt' => Yii::t('app', 'Please select')]	
					) ?>	
				
				</div>
			</div>
			
			<div id="key-figures" class="panel panel-default">
				<div class="panel-heading">
					<h3>Key Figures</h3>
				</div>
				<div class="panel-body">
					<?= $form->field($model, 'distance_in_km') ?>
					
					<?= $form->field($model, 'duration_in_min') ?>
					
					<?= $form->field($model, 'start_altitude') ?>
					
					<?= $form->field($model, 'end_altitude') ?>
					
					<?= $form->field($model, 'ascent') ?>
					
					<?= $form->field($model, 'descent') ?>
					
					<?= $form->field($model, 'min_altitude') ?>
					
					<?= $form->field($model, 'max_altitude') ?>
					
				</div>
			</div>
			
			<div id="sbb" class="panel panel-default">
				<div class="panel-heading">
					<h3>SBB</h3>
				</div>
				<div class="panel-body">
					<?= $form->field($model, 'arrival_station')
						->hint('Please use the exact station name like on <a href="https://sbb.ch" target="_blank">sbb.ch</a>. Otherwise the link to the SBB time schedule will not work.') ?>
					
					<?= $this->render('/translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'directions',
						'translations' => $translations,
						'translationModel' => $translationModel,
						'isWysiwyg' => true,
						'hint' => Yii::t('app', 'Example: «Follow the signs in the direction of ...»')
					]); ?>
					
					<hr />
					
					<?= $form->field($model, 'departure_station')
						->hint('Please use the exact station name like on <a href="https://sbb.ch" target="_blank">sbb.ch</a>. Otherwise the link to the SBB time schedule will not work.') ?>
				</div>
			</div>
			
			<div id="geo" class="panel panel-default">
				<div class="panel-heading">
					<h3>Geo</h3>
				</div>
				<div class="panel-body">
					<?= $form->field($model, 'geojsonFile')->widget(FileInput::classname(), [
						'options' => ['accept' => 'application/geo+json'],
						'pluginOptions' => [
							'showPreview' => false,
							'showCaption' => true,
							'showRemove' => true,
							'showUpload' => false
						]
					]) ?>
					<div class="hint-block"><strong>Important</strong>: Use only the geometry type <code>LineString</code> in the Swiss projection <code>EPSG:21781</code>. Please check if the route is displayed correctly on the map after the upload.</div>
					
					<hr />
					
					<?= $form->field($model, 'removeGeom')->checkbox() ?>
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
					<?php if ($user->isAdmin()): ?>
						<?= $form->field($contentModel, 'general')->checkbox()
							->hint(Yii::t("app", "General routes are displayed on the first map layer when fully zoomed out. Use it for Grand Tours, for example.")) ?>
						<?= $form->field($contentModel, 'featured')->checkbox()
							->hint(Yii::t("app", "Featured items are displayed first on the homepage and in search results (can only be set by admins).")) ?>
					<?php endif; ?>
								
					<?= $form->field($contentModel, 'priority')->dropDownList($model->priorities)
						->hint(Yii::t("app", "Influences where the route appears in filter and search results.")) ?>
					
					<?php
					if ($user->isAdmin())
					{
						echo $form->field($contentModel, 'published')->checkbox();
					}
					else
						echo $form->field($contentModel, 'published')->checkbox()
							->hint(Yii::t("app", "When you publish a route, it will be approved before it is available online."));
					?>
					
					<?= $form->field($contentModel, 'hidden')->checkbox()
						->hint(Yii::t("app", "If hidden, the route won't be shown in overviews but it will still be available via direct link.")) ?>
					
					<?= $form->field($contentModel, 'archive')->checkbox()
						->hint(Yii::t("app", "You can archive a route and activate it later again. Archived routes won't be shown.")) ?>
				</div>
			</div>
			
			<?= $this->render('/common/_qualityControlForm', [
				'model' => $model,
				'contentModel' => $contentModel,
				'form' => $form
			]) ?>
			
		</div>
		
		<?= $this->render('/common/_saveColumn', [
			'form' => $form,
			'model' => $model,
			'contentModel' => $contentModel,
			'showLangSwitch' => true,
			'viewUrl' => $viewUrl,
			'nav' => $nav
		]) ?>
   		
   	</div>

    <?php ActiveForm::end(); ?>

</div>
