<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Heritage;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CodeGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Code Groups');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Code Series'), 'url' => ['code-series/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Code Series') .' #'. $codeSeries->id, 'url' => ['code/index', 'id' => $codeSeries->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="code-group-index">

    <h1><?= Yii::t('app', 'Code Series') .' #'. $codeSeries->id ?></h1>
    
    <?= $this->render('/common/_codeNavPills', [
    	'model' => $codeSeries,
    	'active' => 2
    ]) ?>
    
    <p>
        <?= Html::a(Yii::t('app', 'Create Code Group'), ['code-group/create', 'id' => $codeSeries->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'title',
            'code_count',
            [
				'attribute' => 'heritage_id',
				'value' => function ($model) {
					if (isset($model->heritage))
						return $model->heritage->short_name;
				},
				'filter' => Heritage::getHeritages(),
			],
            [
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update}'
			]
        ],
    ]); ?>


</div>
