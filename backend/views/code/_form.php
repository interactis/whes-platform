<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Content;
use kartik\select2\Select2;

$js = "
	var typeUrl = ". $model::TYPE_URL ."
	$('#code-type').change(function() {
		var val = this.value
		
		if (this.value == typeUrl) {
			$('.set-url').removeClass('hidden');
			$('.select-content').addClass('hidden');
		}
		else {
			$('.set-url').addClass('hidden');
			$('.select-content').removeClass('hidden');
		}
	});
";

$this->registerJs($js, $this::POS_READY);

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
					
					<?= $form->field($model, 'type')->dropDownList($model->types)
						->hint(Yii::t('app', '<strong>Info</strong> = Link to content | <strong>Collect</strong> = Content will be added to rucksack | <strong>URL</strong> = Link by your choice')) ?>
					
					<div class="form-group select-content <?= ($model->type != $model::TYPE_URL ? '' : 'hidden') ?>">
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
					
					<div class="set-url <?= ($model->type != $model::TYPE_URL ? 'hidden' : '') ?>">
						<?= Html::activeLabel($model, 'url') ?>
					
						<div class="row">
							<div class="col-xs-5 col-sm-3">
								<i><?= Yii::$app->params['frontendUrl'] ?></i>
							</div>
							<div class="col-xs-7 col-sm-9">
								<?php
								$testUrl = Yii::$app->params['frontendUrl'] . $model->url;
								echo $form->field($model, 'url')->label(false)->hint(Yii::t('app', 'Test') .': <a href="'. $testUrl .'" target="_blank">'. $testUrl .'</a>');
								?>
							</div>
						</div>
					</div>
					
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
