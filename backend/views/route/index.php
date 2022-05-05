<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Heritage;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\RouteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Routes');
$this->params['breadcrumbs'][] = $this->title;

$boolFilter = [
	1 => Yii::t('app', 'Yes'),
	0 => Yii::t('app', 'No')
];

$colums = [
	['class' => 'yii\grid\SerialColumn'],
	'id',
	'title',
	[
		'attribute' => 'tags',
		'value' => function ($model) {
			return implode(', ', $model->content->tagList);
		}
	]
];

$user = Yii::$app->user->identity;
if ($user->isAdmin())
{
	array_push($colums,
		[
			'attribute' => 'heritage',
			'value' => function ($model) {
				if (isset($model->content->heritage))
					return $model->content->heritage->short_name;
			},
			'filter' => Heritage::getHeritages(true)
		],
		[
			'attribute' => 'general',
			'value' => function ($model) {
				return ($model->content->general ? Yii::t('app', 'Yes') :  Yii::t('app', 'No'));
			},
			'filter' => $boolFilter,
		],
		[
			'attribute' => 'featured',
			'value' => function ($model) {
				return ($model->content->featured ? Yii::t('app', 'Yes') :  Yii::t('app', 'No'));
			},
			'filter' => $boolFilter,
		],
		[
			'attribute' => 'imported',
			'value' => function ($model) {
				return ($model->content->imported ? Yii::t('app', 'Yes') :  Yii::t('app', 'No'));
			},
			'filter' => $boolFilter,
		]
	);
}

array_push($colums,
	[
		'attribute' => 'priority',
		'value' => function ($model) {
			return $model->priorities[$model->content->priority];
		},
		'filter' => $searchModel->priorities,
	],
	[
		'attribute' => 'published',
		'value' => function ($model) {
			return ($model->content->published ? Yii::t('app', 'Yes') :  Yii::t('app', 'No'));
		},
		'filter' => $boolFilter,
	],
	[
		'attribute' => 'hidden',
		'value' => function ($model) {
			return ($model->content->hidden ? Yii::t('app', 'Yes') :  Yii::t('app', 'No'));
		},
		'filter' => $boolFilter,
	],
	[
		'attribute' => 'archive',
		'value' => function ($model) {
			return ($model->content->archive ? Yii::t('app', 'Yes') :  Yii::t('app', 'No'));
		},
		'filter' => $boolFilter,
	],
	[
		'class' => 'yii\grid\ActionColumn',
		'template' => '{update} {delete}'
	]
);
?>

<div class="route-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Route'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $colums,
    ]); ?>


</div>
