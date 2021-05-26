<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\FlagTranslation;
use common\models\FlagGroup;

$translations = $model->flagTranslations;
$translationModel = new FlagTranslation();
?>

<div class="flag-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="row">
    	<div class="col-md-10 col-lg-8">
    	
			<div id="flag" class="panel panel-default">
				<div class="panel-heading">
					<h3>Filter</h3>
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
						'field' => 'disclaimer',
						'translations' => $translations,
						'translationModel' => $translationModel,
						'isWysiwyg' => true
					]) ?>
					
					<?= $form->field($model, 'operator')->dropDownList($model->operators)
						->hint(Yii::t('app', 'Operator that is applied in combination with other filters.')) ?>
					
					<?= $form->field($model, 'order')->textInput()
						->hint(Yii::t('app', 'If necessary, use a number to sort the flags among themselves.')) ?>
						
					<?= $form->field($model, 'label')->checkbox()
						->hint(Yii::t("app", "Select if it should be used as a label.")) ?>
					
					<?= $form->field($model, 'hidden')->checkbox()
						->hint(Yii::t("app", "If hidden, the flag won't be shown in the frontend views.")) ?>

				</div>
			</div>
			
		</div>
		
		<?= $this->render('/common/_saveColumn', ['form' => $form, 'model' => $model]) ?>
   		
   	</div>

    <?php ActiveForm::end(); ?>

</div>
