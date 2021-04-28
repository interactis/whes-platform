<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\TagTranslation;

$translations = $model->tagTranslations;
$translationModel = new TagTranslation();
?>

<div class="tag-form">

    <?php $form = ActiveForm::begin(); ?>
    
     <div class="row">
    	<div class="col-md-10 col-lg-8">
    	
			<div id="tag" class="panel panel-default">
				<div class="panel-heading">
					<h3>Tag</h3>
				</div>
				<div class="panel-body">
					
					<?= Yii::$app->controller->renderPartial('//translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'title',
						'translations' => $translations,
						'translationModel' => $translationModel
					]); ?>
					
					<?= $form->field($model, 'active')->checkbox() ?>

				</div>
			</div>
			
		</div>
		
		<?= Yii::$app->controller->renderPartial('//common/_saveColumn', ['form' => $form, 'model' => $model]) ?>
   		
   	</div>

    <?php ActiveForm::end(); ?>

</div>
