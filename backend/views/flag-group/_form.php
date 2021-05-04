<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\FlagGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="flag-group-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
    	<div class="col-md-10 col-lg-8">
    	
			<div id="flag-group" class="panel panel-default">
				<div class="panel-heading">
					<h3>Flag Group</h3>
				</div>
				<div class="panel-body">
				
					<?= $form->field($model, 'order')->textInput() ?>

					<?= $form->field($model, 'hidden')->checkbox() ?>
				
				</div>
			</div>
			
		</div>
		
		<?= Yii::$app->controller->renderPartial('//common/_saveColumn', ['form' => $form, 'model' => $model]) ?>
   		
   	</div>

    <?php ActiveForm::end(); ?>

</div>
