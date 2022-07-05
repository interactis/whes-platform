<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProfileItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Profile');

$user = Yii::$app->user->identity;
if ($user->isAdmin())
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Heritages'), 'url' => ['heritage/index']];

$this->params['breadcrumbs'][] = ['label' => $heritage->short_name, 'url' => ['heritage/update', 'id' => $heritage->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-item-index">

    <h1><?= Html::encode($heritage->name) ?></h1>
    
    <?= $this->render('/common/_navPills', [
    	'model' => $heritage,
    	'active' => 3
    ]) ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Profile Item'), ['create', 'id' => $heritage->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'order',

            [
				'class' => 'yii\grid\ActionColumn',
				'template' => '{update} {delete}'
			]
        ],
    ]); ?>


</div>
