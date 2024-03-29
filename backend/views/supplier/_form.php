<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\SupplierTranslation;
use common\models\Heritage;

$translations = $model->supplierTranslations;
$translationModel = new SupplierTranslation();
?>

<div class="supplier-form">

    <?php $form = ActiveForm::begin(); ?>
    
     <div class="row">
    	<div class="col-md-10 col-lg-8">
    	
			<div id="supplier" class="panel panel-default">
				<div class="panel-heading">
					<h3>Supplier</h3>
				</div>
				<div class="panel-body">
					
					<?= $this->render('/translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'name',
						'translations' => $translations,
						'translationModel' => $translationModel
					]); ?>
					
					<?= $this->render('/translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'name_affix',
						'translations' => $translations,
						'translationModel' => $translationModel
					]); ?>
					
					<?php
					$user = Yii::$app->user->identity;
					if ($user->isAdmin())
					{
						echo $form->field($model, 'heritage_id')->dropDownList(
							Heritage::getHeritages(),
							['prompt' => Yii::t('app', 'Please select')]
						);
					}
					?>
					
					<hr />
					
					<div class="row">
						<div class="col-sm-8">
							<?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>
						</div>
						<div class="col-sm-4">
							<?= $form->field($model, 'street_number')->textInput(['maxlength' => true]) ?>
						</div>
					</div>

					<?= $form->field($model, 'address_addition')->textInput(['maxlength' => true]) ?>
					
					<div class="row">
						<div class="col-sm-4">
							<?= $form->field($model, 'zip')->textInput(['maxlength' => true]) ?>
						</div>
						<div class="col-sm-8">
							<?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
						</div>
					</div>
						
					<hr />

					<?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

					<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

					<?= $form->field($model, 'phone')->textInput(['maxlength' => true])
						->hint(Yii::t('app', 'Please use the country code (+41 ...) to make it easier for foreign visitors.')) ?>
					
					<?= $this->render('/translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'remarks',
						'translations' => $translations,
						'translationModel' => $translationModel,
						'isWysiwyg' => true
					]); ?>
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
