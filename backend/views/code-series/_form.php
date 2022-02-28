<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CodeSeries */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="code-series-form">

    <?php $form = ActiveForm::begin(); ?>
    
     <div class="row">
    	<div class="col-md-10 col-lg-8">
    	
			<div id="info" class="panel panel-default">
				<div class="panel-heading">
					<h3>Code Series</h3>
				</div>
				<div class="panel-body">
   					 <?= $form->field($model, 'code_count')->textInput()
   					 	->hint(Yii::t('app', 'It can take a few minutes until the codes are generated. Please do not close the browser window.')) ?>
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
