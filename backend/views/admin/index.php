<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Heritage;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Admin Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Admin User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'email:email',
            
            [
                'attribute' => 'heritage_id',
                'value' => function ($model) {
                	if (isset($model->heritage))
                    	return $model->heritage->short_name;
                },
                'filter' => Heritage::getHeritages(),
            ],
            
            [
                'attribute' => 'role',
                'value' => function ($model) {
                    return $model->roles[$model->role];
                },
                'filter' => $searchModel->roles,
            ],
            
            [
            	'class' => 'yii\grid\ActionColumn',
            	'template' => '{update} {delete}'
            ]

        ],
    ]); ?>


</div>
