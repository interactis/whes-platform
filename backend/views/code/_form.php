<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Content;
use kartik\select2\Select2;
?>

<div class="code-form">

    <?php $form = ActiveForm::begin(); ?>
    
     <div class="row">
    	<div class="col-md-10 col-lg-8">
    	
			<div id="info" class="panel panel-default">
				<div class="panel-heading">
					<h3>Info</h3>
				</div>
				<div class="panel-body">
				
					<div class="form-group">
						<?= Html::activeLabel($model, 'content') ?>
	
						<?= Select2::widget([
							'name' => 'Code[content_id]',
							'value' => $model->content_id,
							'data' => Content::getContentList(),
							'maintainOrder' => true,
							'showToggleAll' => false,
							'options' => [
								'placeholder' => Yii::t('app', 'Search and select content'), 
								'multiple' => false
							],
							'pluginOptions' => [
								'maximumInputLength' => 20
							]
						]) ?>
					</div>
					
					<?= $form->field($model, 'type')->dropDownList($model->types)
						->hint(Yii::t('app', '<strong>Info</strong> = Link to content<br /><strong>Collect</strong> = Content will be added to rucksack')) ?>
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
