<?php
use yii\helpers\Html;
use yii\grid\GridView;

$type = $content->types[$content->type];
$contentModel = $content->{$type};

$this->title = Yii::t('app', 'Downloads');
$this->params['breadcrumbs'][] = ['label' => $contentModel->pluralName(), 'url' => [$type .'/index']];
$this->params['breadcrumbs'][] = ['label' => $contentModel->title, 'url' => [$type .'/update', 'id' => $contentModel->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="download-index">

    <h1><?= $contentModel->title ?></h1>
    
    <?= $this->render('/common/_contentNavPills', [
    	'model' => $content,
    	'active' => 4,
    	'showDownloads' => true
    ]) ?>
	
    <p>
        <?= Html::a(Yii::t('app', 'Create Download'), ['create', 'id' => $content->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'order',
            'hidden:boolean',

            [
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update} {delete}'
			]
        ],
    ]); ?>


</div>
