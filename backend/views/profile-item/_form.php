<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\ProfileItemTranslation;

$translations = $model->profileItemTranslations;
$translationModel = new ProfileItemTranslation();
?>

<div class="profile-item-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="row">
    	<div class="col-md-10 col-lg-8">
    	
			<div id="profile-item" class="panel panel-default">
				<div class="panel-heading">
					<h3>Profile Item</h3>
				</div>
				<div class="panel-body">
					
					<?= $this->render('/translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'title',
						'translations' => $translations,
						'translationModel' => $translationModel
					]) ?>
					
					<?= $this->render('/translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'description',
						'translations' => $translations,
						'translationModel' => $translationModel,
						'isWysiwyg' => true
					]) ?>
					
					<?= $form->field($model, 'order')->textInput() ?>
					
				</div>
			</div>
			
		</div>
		
		<?= $this->render('/common/_saveColumn', [
			'form' => $form,
			'model' => $model,
			'showLangSwitch' => true
		]) ?>
   		
   	</div>

    <?php ActiveForm::end(); ?>

</div>
