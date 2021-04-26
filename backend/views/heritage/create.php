<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Heritage */

$this->title = Yii::t('app', 'Create Heritage');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Heritages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="heritage-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
