<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Code */

$user = Yii::$app->user->identity;
$this->title = Yii::t('app', 'Code') .': '. $model->code;
if ($user->isAdmin())
{
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Code Series'), 'url' => ['code-series/index']];
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Code Series') .' #'. $codeSeries->id, 'url' => ['code/index', 'id' => $codeSeries->id]];
}
else
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'NFC Codes'), 'url' => ['code/list']];

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="code-update">

    <h1><?= Yii::t('app', 'Code') .': <code>'. $model->code .'</code>' ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
