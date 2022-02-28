<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Heritage;

/* @var $this yii\web\View */
/* @var $model common\models\CodeGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="code-group-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="row">
    	<div class="col-md-10 col-lg-8">
    	
			<div id="info" class="panel panel-default">
				<div class="panel-heading">
					<h3>Info</h3>
				</div>
				<div class="panel-body">
					
					<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
					
					<?= $form->field($model, 'heritage_id')->textInput()->dropDownList(
						Heritage::getHeritages(),
						['prompt' => Yii::t('app', 'Please select')]
					) ?>
					
					<?php
					if ($showCodeCount)
						echo $form->field($model, 'code_count')->textInput();
					?>
					
				</div>
			</div>
		</div>
		<?= $this->render('/common/_saveColumn', [
			'form' => $form,
			'model' => $model
		]) ?>
   	</div>
    <?php ActiveForm::end(); ?>

</div>
