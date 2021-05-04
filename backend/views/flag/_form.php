<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Flag */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="flag-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="row">
    	<div class="col-md-10 col-lg-8">
    	
			<div id="flag" class="panel panel-default">
				<div class="panel-heading">
					<h3>Flag</h3>
				</div>
				<div class="panel-body">

					<?= $form->field($model, 'flag_group_id')->textInput() ?>
					
					<?= $form->field($model, 'order')->textInput() ?>
					
					<?= $form->field($model, 'hidden')->checkbox() ?>

				</div>
			</div>
			
		</div>
		
		<?= Yii::$app->controller->renderPartial('//common/_saveColumn', ['form' => $form, 'model' => $model]) ?>
   		
   	</div>

    <?php ActiveForm::end(); ?>

</div>
