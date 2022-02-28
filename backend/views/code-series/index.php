<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CodeSeriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Code Series');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="code-series-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Code Series'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
    $user = Yii::$app->user->identity;
    if ($user->isSuperAdmin())
    {
   		 $actionCollumn = [
			'class' => 'yii\grid\ActionColumn',
			'template' => '{view} {delete}'
		]; 
    }
    else
    {
    	 $actionCollumn = [
			'class' => 'yii\grid\ActionColumn',
			'template' => '{view}'
		]; 
    }
    
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'code_count',
            'created_at:datetime',

             $actionCollumn
        ],
    ]); ?>


</div>
