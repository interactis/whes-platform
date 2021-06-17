<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PoiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'To approve');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="quality-control-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'updated_at:datetime',
            [
				'attribute' => 'Type',
				'value' => function ($model) {
					return strtoupper($model->typeText);
				}
			],
			[
				'attribute' => 'Heritage',
				'value' => function ($model) {
					return $model->heritage['short_name'];
				}
			],
			[
				'attribute' => 'Title',
				'value' => function ($model) {
					return $model->{$model->typeText}['title'];
				}
			],

            [
            	'class' => 'yii\grid\ActionColumn',
            	'template' => '{update}',
            	'urlCreator' => function ($action, $model, $key, $index) {
        			if ($action === 'update') {
            			return Url::to([$model->typeText .'/update', 'id' => $model->{$model->typeText}['id']]);
        			}
    			},
            ]
        ],
    ]); ?>

</div>
