<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FlagGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Filter Groups');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flag-group-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Filter Group'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            [
				'attribute' => 'operator',
				'value' => function ($model) {
					return strtoupper($model->operator);
				}
			],
            'order',
            'hidden:boolean',

            [
            	'class' => 'yii\grid\ActionColumn',
            	'template' => '{update} {delete}'
            ]
        ],
    ]); ?>


</div>
