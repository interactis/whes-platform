<?php
use yii\grid\GridView;
use yii\helpers\Url;
?>

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
				if ($model->heritage)
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
