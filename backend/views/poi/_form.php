<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\PoiTranslation;
use backend\components\poipicker\PoiPicker;

$translations = $model->poiTranslations;
$translationModel = new PoiTranslation();

$nav = [
	[
		'slug' => 'info',
		'title' => 'Info'
	],
	[
		'slug' => 'directions',
		'title' => 'Directions'
	],
	[
		'slug' => 'tickets',
		'title' => 'Tickets'
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
if (!$model->isNewRecord && $contentModel->published && !$contentModel->archive)
{
	$viewUrl = Yii::$app->params['frontendUrl'];
	
	if ($contentModel->edu && !$contentModel->visitor)
		$viewUrl = Yii::$app->params['eduUrl'];
	
	$viewUrl .= 'poi/'. $model->slug;
}
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
					
					<div class="<?= ($model->isNewRecord ? 'hidden' : '') ?>">
						<?= Yii::$app->controller->renderPartial('//translation/field', [
							'model' => $model,
							'form' => $form,
							'field' => 'slug',
							'translations' => $translations,
							'translationModel' => $translationModel,
							'hint' => Yii::t('app', 'The slug is used in the URL. Example: <strong>https://ourheritage.ch/poi/<code>this-is-a-slug</code></strong>')
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
						'field' => 'remarks',
						'translations' => $translations,
						'translationModel' => $translationModel,
						'isWysiwyg' => true
					]); ?>
				
				</div>
			</div>
			
			<div id="directions" class="panel panel-default">
				<div class="panel-heading">
					<h3>Directions</h3>
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
				</div>
			</div>
			
			<div id="tickets" class="panel panel-default">
				<div class="panel-heading">
					<h3>Tickets</h3>
				</div>
				<div class="panel-body">
					<?= $this->render('/translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'ticket_title',
						'translations' => $translations,
						'translationModel' => $translationModel
					]); ?>
					
					<?= $this->render('/translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'ticket_button_url',
						'translations' => $translations,
						'translationModel' => $translationModel
					]); ?>
					
					<?= $this->render('/translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'ticket_button_text',
						'translations' => $translations,
						'translationModel' => $translationModel
					]); ?>
					
					<?= $this->render('/translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'ticket_remarks',
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
					<?= PoiPicker::widget(['model' => $model, 'attribute' => 'geom']) ?>
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
						<?= $form->field($contentModel, 'featured')->checkbox()
							->hint(Yii::t("app", "Featured items are displayed first on the homepage and in search results (can only be set by admins).")) ?>
					<?php endif; ?>
					
					<?= $form->field($contentModel, 'priority')->dropDownList($model->priorities)
						->hint(Yii::t("app", "Influences where the POI appears in filter and search results.")) ?>
					
					<?php
					if ($user->isAdmin())
					{
						echo $form->field($contentModel, 'published')->checkbox();
					}
					else
						echo $form->field($contentModel, 'published')->checkbox()
							->hint(Yii::t("app", "When you publish a POI, it will be approved before it is available online."));
					?>
					
					<?= $form->field($contentModel, 'hidden')->checkbox()
						->hint(Yii::t("app", "If hidden, the POI won't be shown in overviews but it will still be available via direct link.")) ?>
						
					<?= $form->field($contentModel, 'archive')->checkbox()
						->hint(Yii::t("app", "You can archive a POI and activate it later again. Archived POIs won't be shown.")) ?>
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
			'showLangSwitch' => true,
			'viewUrl' => $viewUrl,
			'nav' => $nav
		]) ?>
   		
   	</div>

    <?php ActiveForm::end(); ?>

</div>
