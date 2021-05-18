<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\MediaTranslation;
use kartik\file\FileInput;

$translations = $model->mediaTranslations;
$translationModel = new MediaTranslation();
?>

<div class="media-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
    	<div class="col-md-10 col-lg-8">
    	
			<div id="image" class="panel panel-default">
				<div class="panel-heading">
					<h3>Image</h3>
				</div>
				<div class="panel-body">
				
					<div class="row">
						<div class="col-md-4">
							<?= $model->getImageHtml(400, 'img-thumbnail', 'Media image') ?>
						</div>
						<div class="col-md-8">
							<?= $form->field($model, 'image_file')->widget(FileInput::classname(), [
								'options' => ['accept' => 'image/*'],
								'pluginOptions' => [
									'showPreview' => false,
									'showCaption' => true,
									'showRemove' => true,
									'showUpload' => false
								]
							]) ?>
						</div>
					</div>
					<br />
				
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
					
					<?= $this->render('/translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'copyright',
						'translations' => $translations,
						'translationModel' => $translationModel
					]); ?>
   
    				<?= $form->field($model, 'order')->textInput()
    					->hint(Yii::t('app', 'If necessary, use a number to sort the images among themselves.')) ?>
				</div>
			</div>
			
		</div>
		
		<?= $this->render('/common/_saveColumn', ['form' => $form, 'model' => $model, 'showLangSwitch' => true]) ?>
   		
   	</div>

    <?php ActiveForm::end(); ?>

</div>
