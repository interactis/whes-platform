<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\TagTranslation;

$translations = $model->tagTranslations;
$translationModel = new TagTranslation();

$tagValue = [];
if (isset($model->relatedTags))
	$tagValue = ArrayHelper::map($model->relatedTags, 'related_tag_id', 'related_tag_id');
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
					
					<?= $this->render('/translation/field', [
						'model' => $model,
						'form' => $form,
						'field' => 'title',
						'translations' => $translations,
						'translationModel' => $translationModel
					]); ?>
					
					<hr />
					
					<?= $this->render('/common/_tagSelect', [
						'model' => $model,
						'tagValue' => $tagValue,
					]); ?>
					
					<?php if (count($model->relatingTags) > 0): ?>
						<label><?= Yii::t('app', 'Relating Tags') ?></label>
						<p>
							<?php
							foreach($model->relatingTags as $rel)
							{
								$tag = $rel->tag;
								echo Html::a($tag->title, ['tag/update', 'id' => $tag->id]);
							}
							?>
						</p>
					<?php endif; ?>
					
					<hr />
					
					<?= $form->field($model, 'active')->checkbox() ?>

				</div>
			</div>
			
		</div>
		
		<?= $this->render('/common/_saveColumn', ['form' => $form, 'model' => $model]) ?>
   		
   	</div>

    <?php ActiveForm::end(); ?>

</div>
