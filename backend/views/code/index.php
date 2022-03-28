<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CodeGroup;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CodeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Code Series') .' #'. $codeSeries->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Code Series'), 'url' => ['code-series/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="code-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('/common/_codeNavPills', [
    	'model' => $codeSeries,
    	'active' => 1
    ]) ?>
    
    <div class="margin-bottom">
		<p class="small"><strong>Excel Download:</strong><p>
		<?= ExportMenu::widget([
			'dataProvider' => $downloadDataProvider,
			'filename' => 'Code_Series_'. $codeSeries->id,
			'showConfirmAlert' => false,
			'exportConfig' => [
				ExportMenu::FORMAT_HTML => false,
				ExportMenu::FORMAT_TEXT => false,
				ExportMenu::FORMAT_PDF => false
			]
		]) ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'code',
            [
				'attribute' => 'code_group_id',
				'value' => function ($model) {
					if (isset($model->codeGroup))
					{
						return $model->codeGroup->title;
					}
					else
						return '';
				},
				'filter' => CodeGroup::getCodeGroups($codeSeries->id),
			],
            [
				'attribute' => 'content_id',
				'value' => function ($model) {
					
					if ($model->content)
					{
						$typeContent = $model->content->typeContent;
						if ($typeContent)
						{
							return $typeContent->title .' ('. $model->content->typeText .')';
						}	
					}
					return '';	
				},
				'filter' => false,
			],
            [
                'attribute' => 'type',
                'value' => function ($model) {
					return $model->types[$model->type];
                },
                'filter' => $searchModel->types,
            ],
            'active:boolean',

            [
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update}'
			]
        ],
    ]); ?>


</div>
