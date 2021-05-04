<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Flag */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Flag Groups'), 'url' => ['flag-group/index']];
$this->params['breadcrumbs'][] = ['label' => $flagGroup->title, 'url' => ['flag-group/update', 'id' => $flagGroup->id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Flags'), 'url' => ['index', 'id' => $flagGroup->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flag-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
