<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\HeritageTranslation;

$translations = $model->heritageTranslations;
$translationModel = new HeritageTranslation();

$viewUrl = false;
if (!$model->isNewRecord)
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
				
					<?= Yii::$app->controller->renderPartial('//translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'name',
						'translations' => $translations,
						'translationModel' => $translationModel
					]); ?>
					
					<?= Yii::$app->controller->renderPartial('//translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'short_name',
						'translations' => $translations,
						'translationModel' => $translationModel,
						'hint' => Yii::t('app', 'Use the full name here if no short name is available.')
					]); ?>
					
					<?= Yii::$app->controller->renderPartial('//translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'description',
						'translations' => $translations,
						'translationModel' => $translationModel,
						'isWysiwyg' => true
					]); ?>
					
					<?= Yii::$app->controller->renderPartial('//translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'link_url',
						'translations' => $translations,
						'translationModel' => $translationModel
					]); ?>
					
					<?= Yii::$app->controller->renderPartial('//translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'link_text',
						'translations' => $translations,
						'translationModel' => $translationModel
					]); ?>

					<?php // $form->field($model, 'geom') ?>

					<?= $form->field($model, 'published')->checkbox() ?>

					<?= $form->field($model, 'hidden')->checkbox()->hint(Yii::t("app", "If hidden, the heritage won't be shown in overviews but it will still be available via direct link.")) ?>
			
				</div>
			</div>
			
		</div>
		
		<?= Yii::$app->controller->renderPartial('//common/_saveColumn', ['form' => $form, 'model' => $model, 'showLangSwitch' => true, 'viewUrl' => $viewUrl]) ?>
   		
   	</div>

    <?php ActiveForm::end(); ?>
		
</div>
