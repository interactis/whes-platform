<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\CodeGroup;

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
						return $model->codeGroup->title;
				},
				'filter' => CodeGroup::getCodeGroups($codeSeries->id),
			],
            'content_id',
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
