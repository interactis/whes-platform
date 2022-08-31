<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Heritage;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SupplierSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Suppliers');
$this->params['breadcrumbs'][] = $this->title;

$colums = [
	['class' => 'yii\grid\SerialColumn'],
	'id',
	'name'
];

$user = Yii::$app->user->identity;
if ($user->isAdmin())
{
	array_push($colums,
		[
			'attribute' => 'heritage_id',
			'value' => function ($model) {
				if (isset($model->heritage))
					return $model->heritage->short_name;
			},
			'filter' => Heritage::getHeritages()
		],
	);
}

array_push($colums,
	[
		'class' => 'yii\grid\ActionColumn',
		'template' => '{update} {delete}'
	]
);
?>

<div class="supplier-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Supplier'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $colums,
    ]); ?>


</div>
