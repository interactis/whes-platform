<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\DownloadTranslation;

$translations = $model->downloadTranslations;
$translationModel = new DownloadTranslation();
?>

<div class="download-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="row">
    	<div class="col-md-10 col-lg-8">
    	
			<div id="supplier" class="panel panel-default">
				<div class="panel-heading">
					<h3>Download</h3>
				</div>
				<div class="panel-body">
					
					<label>File Upload</label>
					
					<?= Yii::$app->controller->renderPartial('//translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'file',
						'translations' => $translations,
						'translationModel' => $translationModel,
						'isFileInput' => true,
						'fileType' => 'pdf',
						'hideLabel' => true
					]); ?>
					
					<hr />
					
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
						'isWysiwyg' => true
					]); ?>
					
					<?= $form->field($model, 'order')->textInput()
    					->hint(Yii::t('app', 'If necessary, use a number to sort the documents among themselves.')) ?>
					
					<?= $form->field($model, 'hidden')->checkbox() ?>
				
				</div>
			</div>
			
		</div>
		
		<?= $this->render('/common/_saveColumn', [
			'form' => $form,
			'model' => $model,
			'showLangSwitch' => true,
		]) ?>
   		
   	</div>

    <?php ActiveForm::end(); ?>

</div>
