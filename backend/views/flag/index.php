<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FlagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Filters');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Filter Groups'), 'url' => ['flag-group/index']];
$this->params['breadcrumbs'][] = ['label' => $flagGroup->title, 'url' => ['flag-group/update', 'id' => $flagGroup->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flag-index">

    <h1><?= $flagGroup->title ?></h1>
	
	<?= $this->render('/common/_flagNavPills', [
    	'model' => $flagGroup,
    	'active' => 2
    ]) ?>
	
    <p>
        <?= Html::a(Yii::t('app', 'Create Filter'), ['create', 'id' => $flagGroup->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'order',
            'label:boolean',
            'hidden:boolean',

            [
            	'class' => 'yii\grid\ActionColumn',
            	'template' => '{update} {delete}'
            ]
        ],
    ]); ?>


</div>
