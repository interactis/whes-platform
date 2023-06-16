<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\PageTranslation;

$translations = $model->pageTranslations;
$translationModel = new PageTranslation();

if (!empty($model->slug))
{
	$viewUrl = Yii::$app->params['frontendUrl'] .'site/'. $model->slug;
}
else
{
	$viewUrl = Yii::$app->params['frontendUrl'];
	
	// edu
	if ($model->id == 5)
		$viewUrl = Yii::$app->params['eduUrl'];
}
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
    	<div class="col-md-10 col-lg-8">
    		<div id="page" class="panel panel-default">
				<div class="panel-heading">
					<h3>Page</h3>
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
					
					<?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
					
   				</div>
			</div>
		</div>
		
		<?= $this->render('/common/_saveColumn', [
			'form' => $form,
			'model' => $model,
			'viewUrl' => $viewUrl,
			'showLangSwitch' => true
		]) ?>
		
	</div>

    <?php ActiveForm::end(); ?>

</div>
