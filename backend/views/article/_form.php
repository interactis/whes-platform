<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\ArticleTranslation;
use common\models\Heritage;
use common\models\Tag;

$translations = $model->articleTranslations;
$translationModel = new ArticleTranslation();

$viewUrl = false;
if (!$model->isNewRecord)
	$viewUrl = Yii::$app->params['frontendUrl'] .'article/'. $model->slug;

$tagValue = [];
if (isset($model->content->tagMasters))
	$tagValue = ArrayHelper::map($model->content->contentTags, 'tag_id', 'tag_id');

$user = Yii::$app->user->identity;
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
					
					<?php
    				if ($user->isAdmin())
					{
						echo $form->field($contentModel, 'heritage_id')->dropDownList(
							Heritage::getHeritages(),
							['prompt' => Yii::t('app', 'Please select')]
						);
					}
					?>
					
					<div class="form-group">
						<?php
						echo Html::activeLabel($model, 'tags');
						echo Select2::widget([
							'name' => 'Audio[tags]',
							'value' => $tagValue,
							'data' => Tag::getTagList(),
							'maintainOrder' => true,
							'showToggleAll' => false,
							'options' => [
								'placeholder' => Yii::t('app', 'Select tags'), 
								'multiple' => true
							],
							'pluginOptions' => [
								'tags' => true,
								'maximumInputLength' => 20
							]
						]);
						?>
					</div>
					
					<?= $form->field($contentModel, 'priority')->dropDownList($model->priorities)
						->hint(Yii::t("app", "Influences where the article appears in filter and search results.")) ?>
					
					<?= $form->field($contentModel, 'published')->checkbox() ?>
					
					<?= $form->field($contentModel, 'hidden')->checkbox()
						->hint(Yii::t("app", "If hidden, the article won't be shown in overviews but it will still be available via direct link.")) ?>
					
					<?= $form->field($model, 'content_id')->hiddenInput()->label(false) ?>
				
				</div>
			</div>
			
		</div>
		
		<?= Yii::$app->controller->renderPartial('//common/_saveColumn', ['form' => $form, 'model' => $model, 'showLangSwitch' => true, 'viewUrl' => $viewUrl]) ?>
   		
   	</div>

    <?php ActiveForm::end(); ?>

</div>
