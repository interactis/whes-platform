<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Heritage;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\HeritageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Heritages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="heritage-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Heritage'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            [
				'attribute' => 'type',
				'value' => function ($model) {
					return $model->typeText;
				},
				'filter' => Heritage::getTypes()
			],
            'published:boolean',
            'hidden:boolean',

            [
            	'class' => 'yii\grid\ActionColumn',
            	'template' => '{update} {delete}'
            ]
        ],
    ]); ?>


</div>
