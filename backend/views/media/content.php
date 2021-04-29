<?php
use yii\helpers\Html;

$type = $content->types[$content->type];
$contentModel = $content->{$type};

$this->title = Yii::t('app', 'Images');
$this->params['breadcrumbs'][] = ['label' => $contentModel->pluralName(), 'url' => [$type .'/index']];
$this->params['breadcrumbs'][] = ['label' => $contentModel->title, 'url' => [$type .'/update', 'id' => $contentModel->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="media-index">

    <h1><?= $contentModel->title ?></h1>
    
    <?= Yii::$app->controller->renderPartial('//common/_navPills', ['model' => $contentModel, 'active' => 2]) ?>

    <div class="row">
		<div class="col-md-10 col-lg-8">
    		<?php
    		if (count($models) == 0)
    		{
    			echo '<div class="h4">'. Yii::t('app', 'No images yet.') .'</div>';
    		}
    		
    		foreach($models as $i => $model)
    		{
    			echo $this->render('_imagePanel', ['model' => $model, 'type' => 'content', 'count' => $i+1]);
    		}
			?>
    	</div>
    	<div class="col-md-2 col-lg-4">
    		<div class="fixed">
    			<?= Html::a(Yii::t('app', 'Add Image'), ['create-content-media', 'id' => $contentModel->id], ['class' => 'btn btn-success']) ?>
    		</div>
    	</div>
    </div>
</div>
