<?php
use yii\helpers\Html;

$this->title = Yii::t('app', 'Images');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Heritages'), 'url' => ['heritage/index']];
$this->params['breadcrumbs'][] = ['label' => $heritage->short_name, 'url' => ['heritage/update', 'id' => $heritage->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="media-index">

    <h1><?= $heritage->name ?></h1>
    
    <?= Yii::$app->controller->renderPartial('//common/_navPills', ['model' => $heritage, 'active' => 2]) ?>

    <div class="row">
		<div class="col-md-10 col-lg-8">
    		<?php
    		if (count($models) == 0)
    		{
    			echo '<div class="h4">'. Yii::t('app', 'No images yet.') .'</div>';
    		}
    		
    		foreach($models as $i => $model)
    		{
    			echo $this->render('_imagePanel', ['model' => $model, 'type' => 'heritage', 'count' => $i+1]);
    		}
			?>
    	</div>
    	<div class="col-md-2 col-lg-4">
    		<div class="fixed">
    			<?= Html::a(Yii::t('app', 'Add Image'), ['create-heritage-media', 'id' => $heritage->id], ['class' => 'btn btn-success']) ?>
    		</div>
    	</div>
    </div>
</div>
