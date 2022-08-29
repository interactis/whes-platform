<?php
use yii\helpers\Html;

$type = $content->types[$content->type];
$contentModel = $content->{$type};

$this->title = Yii::t('app', 'Images');
$this->params['breadcrumbs'][] = ['label' => $contentModel->pluralName(), 'url' => [$type .'/index']];
$this->params['breadcrumbs'][] = ['label' => $contentModel->title, 'url' => [$type .'/update', 'id' => $contentModel->id]];
$this->params['breadcrumbs'][] = $this->title;

$showSupplier = true;
$showDownloads = false;
if ($type == 'article')
{
	$showSupplier = false;
	$showDownloads = true;
}
?>

<div class="media-index">

    <h1><?= $contentModel->title ?></h1>
    
    <?= Yii::$app->controller->renderPartial('//common/_contentNavPills', [
    	'model' => $content,
    	'active' => 'img',
    	'showSupplier' => $showSupplier,
    	'showDownloads' => $showDownloads
    ]) ?>

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
    			<?= Html::a(Yii::t('app', 'Add Image'), ['create-content-media', 'id' => $content->id], ['class' => 'btn btn-success']) ?>
    		</div>
    	</div>
    </div>
</div>
