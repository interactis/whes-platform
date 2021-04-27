<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Heritage;

/* @var $this yii\web\View */
/* @var $model common\models\Admin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="row">
    	<div class="col-md-10 col-lg-8">
    	
			<div id="user" class="panel panel-default">
				<div class="panel-heading">
					<h3>User</h3>
				</div>
				<div class="panel-body">
				
					<?= $form->field($model, 'email') ?>
					
					<?= $form->field($model, 'password')->textInput()->hint(Yii::t('app', 'Please write down the password and forward it to the user. The password will never be visible later.')) ?>

    				<?= $form->field($model, 'heritage_id')->dropDownList(
    					Heritage::getHeritages(),
    					['prompt' => Yii::t('app', 'Please select')]
    				) ?>
    				
    				<?= $form->field($model, 'role')->dropDownList($model->roles) ?>
    				
				</div>
			</div>
			
		</div>
		
		<?= Yii::$app->controller->renderPartial('//common/_saveColumn', ['form' => $form, 'model' => $model]) ?>
   		
   	</div>

    <?php ActiveForm::end(); ?>

</div>
