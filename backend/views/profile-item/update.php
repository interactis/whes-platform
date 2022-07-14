<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProfileItem */

$this->title = Yii::t('app', 'Update Factsheet Item');

$user = Yii::$app->user->identity;
if ($user->isAdmin())
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Heritages'), 'url' => ['heritage/index']];

$this->params['breadcrumbs'][] = ['label' => $heritage->short_name, 'url' => ['heritage/update', 'id' => $heritage->id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Factsheet'), 'url' => ['index', 'id' => $heritage->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-item-update">

   <h1><?= Html::encode($heritage->name) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
