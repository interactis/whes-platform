<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ArticleTranslation;

$translations = $model->articleTranslations;
$translationModel = new ArticleTranslation();

$viewUrl = false;
if (!$model->isNewRecord)
	$viewUrl = Yii::$app->params['frontendUrl'] .'article/'. $model->slug;
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="row">
    	<div class="col-md-10 col-lg-8">
    	
			<div id="arcticle" class="panel panel-default">
				<div class="panel-heading">
					<h3>Article</h3>
				</div>
				<div class="panel-body">

					<?= $form->field($model, 'content_id')->hiddenInput()->label(false) ?>
					
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
						'field' => 'excerpt',
						'translations' => $translations,
						'translationModel' => $translationModel,
						'isWysiwyg' => true
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
						'isWysiwyg' => true
					]); ?>
				
				</div>
			</div>
			
		</div>
		
		<?= Yii::$app->controller->renderPartial('//common/_saveColumn', ['form' => $form, 'model' => $model, 'showLangSwitch' => true, 'viewUrl' => $viewUrl]) ?>
   		
   	</div>

    <?php ActiveForm::end(); ?>

</div>
