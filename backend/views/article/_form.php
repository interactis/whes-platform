<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ArticleTranslation;

$translations = $model->articleTranslations;
$translationModel = new ArticleTranslation();

$nav = [
	[
		'slug' => 'info',
		'title' => 'Info'
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
if (!$model->isNewRecord)
	$viewUrl = Yii::$app->params['frontendUrl'] .'article/'. $model->slug;
?>

<div class="article-form">

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
						'isWysiwyg' => true,
						'height' => 400
					]); ?>
					
					<?= $form->field($model, 'content_id')->hiddenInput()->label(false) ?>
				
				</div>
			</div>
			
			<?= Yii::$app->controller->renderPartial('//common/_relationsForm', [
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
