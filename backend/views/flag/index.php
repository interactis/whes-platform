<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FlagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Flags');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Flag Groups'), 'url' => ['flag-group/index']];
$this->params['breadcrumbs'][] = ['label' => $flagGroup->title, 'url' => ['flag-group/update', 'id' => $flagGroup->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flag-index">

    <h1><?= $flagGroup->title ?></h1>
	
	<?= Yii::$app->controller->renderPartial('//common/_flagNavPills', [
    	'model' => $flagGroup,
    	'active' => 2
    ]) ?>
	
    <p>
        <?= Html::a(Yii::t('app', 'Create Flag'), ['create', 'id' => $flagGroup->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'order',
            'hidden:boolean',

            [
            	'class' => 'yii\grid\ActionColumn',
            	'template' => '{update} {delete}'
            ]
        ],
    ]); ?>


</div>
