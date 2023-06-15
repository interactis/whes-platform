<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\FlagGroupTranslation;

$translations = $model->flagGroupTranslations;
$translationModel = new FlagGroupTranslation();
?>

<div class="flag-group-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
    	<div class="col-md-10 col-lg-8">
    	
			<div id="flag-group" class="panel panel-default">
				<div class="panel-heading">
					<h3>Filter Group</h3>
				</div>
				<div class="panel-body">
				
					<?= $this->render('/translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'title',
						'translations' => $translations,
						'translationModel' => $translationModel
					]); ?>
					
					<?=
					$form->field($model, 'operator')->dropDownList($model->operators)
						->hint(Yii::t('app', 'Operator that is applied in combination with other filters.'))
					?>
					
					<?= $form->field($model, 'main')->checkbox() ?>
					
					<?= $form->field($model, 'visitor')->checkbox() ?>
					
					<?= $form->field($model, 'edu')->checkbox() ?>
					
					<?= $form->field($model, 'order')->textInput()
						->hint(Yii::t('app', 'If necessary, use a number to sort the filter groups among themselves.')) ?>

					<?= $form->field($model, 'hidden')->checkbox()
						->hint(Yii::t("app", "If hidden, the filter group won't be shown in the frontend views.")) ?>
				
				</div>
			</div>
			
		</div>
		
		<?= $this->render('/common/_saveColumn', ['form' => $form, 'model' => $model]) ?>
   		
   	</div>

    <?php ActiveForm::end(); ?>

</div>
