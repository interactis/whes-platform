<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Download */

$this->title = Yii::t('app', 'Create Download');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Downloads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="download-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
