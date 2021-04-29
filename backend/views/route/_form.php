<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\RouteTranslation;
use common\models\Heritage;

$translations = $model->routeTranslations;
$translationModel = new RouteTranslation();

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
    	
			<div id="arcticle" class="panel panel-default">
				<div class="panel-heading">
					<h3>Route</h3>
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
					
					<?= $form->field($model, 'difficulty') ?>
					
					<?= $form->field($model, 'distance_in_km') ?>
					
					<?= $form->field($model, 'duration_in_min') ?>
					
					<?= $form->field($model, 'min_altitude') ?>
					
					<?= $form->field($model, 'max_altitude') ?>
					
					<?= $form->field($model, 'start_altitude') ?>
					
					<?= $form->field($model, 'end_altitude') ?>
					
					<?= $form->field($model, 'ascent') ?>
					
					<?= $form->field($model, 'descent') ?>
					
					<?= $form->field($model, 'arrival_station') ?>
					
					<?= $form->field($model, 'arrival_url') ?>
					
					<?= $form->field($model, 'departure_station') ?>
					
					<?= $form->field($model, 'departure_url') ?>
					
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
		
		<?= Yii::$app->controller->renderPartial('//common/_saveColumn', ['form' => $form, 'model' => $model, 'showLangSwitch' => true, 'viewUrl' => $viewUrl]) ?>
   		
   	</div>

    <?php ActiveForm::end(); ?>

</div>
