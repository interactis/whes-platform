<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Flag */

$this->title = Yii::t('app', 'Create Flag');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Flags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flag-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
