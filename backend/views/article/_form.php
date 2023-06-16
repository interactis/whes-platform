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
	
	$viewUrl .= 'article/'. $model->slug;
}
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
							'hint' => Yii::t('app', 'The slug is used in the URL. Example: <strong>https://ourheritage.ch/article/<code>this-is-a-slug</code></strong>')
						]); ?>
					</div>
					
					<?= $this->render('/translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'excerpt',
						'translations' => $translations,
						'translationModel' => $translationModel,
						'isWysiwyg' => true
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
						'field' => 'description',
						'translations' => $translations,
						'translationModel' => $translationModel,
						'isWysiwyg' => true,
						'height' => 400
					]); ?>
					
					<?= $form->field($model, 'content_id')->hiddenInput()->label(false) ?>
				
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
						->hint(Yii::t("app", "Influences where the route appears in filter and search results.")) ?>
					
					<?php
					if ($user->isAdmin())
					{
						echo $form->field($contentModel, 'published')->checkbox();
					}
					else
						echo $form->field($contentModel, 'published')->checkbox()
							->hint(Yii::t("app", "When you publish an article, it will be approved before it is available online."));
					?>
					
					<?= $form->field($contentModel, 'hidden')->checkbox()
						->hint(Yii::t("app", "If hidden, the route won't be shown in overviews but it will still be available via direct link.")) ?>
					
					<?= $form->field($contentModel, 'archive')->checkbox()
						->hint(Yii::t("app", "You can archive an articel and activate it later again. Archived articles won't be shown.")) ?>
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
