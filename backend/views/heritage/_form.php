<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Heritage;
use common\models\HeritageTranslation;
use backend\components\poipicker\PoiPicker;
use kartik\file\FileInput;

$translations = $model->heritageTranslations;
$translationModel = new HeritageTranslation();

$nav = [
	[
		'slug' => 'info',
		'title' => 'Info'
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
if (!$model->isNewRecord && $model->published)
	$viewUrl = Yii::$app->params['frontendUrl'] . $model->slug;
?>

<div class="heritage-form">

    <?php $form = ActiveForm::begin(); ?>
    
     <div class="row">
    	<div class="col-md-10 col-lg-8">
    	
			<div id="info" class="panel panel-default">
				<div class="panel-heading">
					<h3>Info</h3>
				</div>
				<div class="panel-body">
				
					<div class="row">
					 	<div class="col-md-2">
					 		<?= $model->getBadge('img-responsive margin-bottom-sm') ?>
					 	</div>
					 	<div class="col-md-10">
							<?= $form->field($model, 'badgeFile')->widget(FileInput::classname(), [
								'options' => ['accept' => 'image/svg+xml, image/png'],
								'pluginOptions' => [
									'showPreview' => false,
									'showCaption' => true,
									'showRemove' => true,
									'showUpload' => false
								]
							]) ?>
						</div>
					</div>
					
					<hr />
					
					<?= $form->field($model, 'type')->dropDownList(
    					Heritage::getTypes()
    				) ?>
					
					<?= $this->render('/translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'name',
						'translations' => $translations,
						'translationModel' => $translationModel
					]); ?>
					
					<?= $this->render('/translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'short_name',
						'translations' => $translations,
						'translationModel' => $translationModel,
						'hint' => Yii::t('app', 'Use the full name here if no short name is available.')
					]); ?>
					
					<div class="<?= ($model->isNewRecord ? 'hidden' : '') ?>">
						<?= Yii::$app->controller->renderPartial('//translation/field', [
							'model' => $model,
							'form' => $form,
							'field' => 'slug',
							'translations' => $translations,
							'translationModel' => $translationModel,
							'hint' => Yii::t('app', 'The slug is used in the URL. Example: <strong>https://ourheritage.ch/<code>this-is-a-slug</code></strong>')
						]); ?>
					</div>
					
					<?= $this->render('/translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'description',
						'translations' => $translations,
						'translationModel' => $translationModel,
						'isWysiwyg' => true
					]); ?>
					
					<?= $this->render('/translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'link_url',
						'translations' => $translations,
						'translationModel' => $translationModel
					]); ?>
					
					<?= $this->render('/translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'link_text',
						'translations' => $translations,
						'translationModel' => $translationModel
					]); ?>

					<?php // $form->field($model, 'geom') ?>
					
					
					<div class="row">
						<div class="col-md-6">
							<?= $form->field($model, 'map_position_x') ?>
						</div>
						<div class="col-md-6">
							<?= $form->field($model, 'map_position_y') ?>
						</div>
					</div>
				</div>
			</div>
			
			<div id="geo" class="panel panel-default">
				<div class="panel-heading">
					<h3>Geo</h3>
				</div>
				<div class="panel-body">
					<div class="hint-block margin-bottom-sm"><?= Yii::t('app', 'Click on the map to position the heritage') ?>:</div>
					<?= PoiPicker::widget(['model' => $model, 'attribute' => 'geom']) ?>
				
					<?= $form->field($model, 'perimeterFile')->widget(FileInput::classname(), [
						'options' => ['accept' => 'application/geo+json'],
						'pluginOptions' => [
							'showPreview' => false,
							'showCaption' => true,
							'showRemove' => true,
							'showUpload' => false
						]
					]) ?>
				</div>
			</div>
			
			<div id="visibility" class="panel panel-default">
				<div class="panel-heading">
					<h3>Visibility</h3>
				</div>
				<div class="panel-body">
					<?= $form->field($model, 'published')->checkbox() ?>

					<?= $form->field($model, 'hidden')->checkbox()->hint(Yii::t("app", "If hidden, the heritage won't be shown in overviews but it will still be available via direct link.")) ?>
			
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
