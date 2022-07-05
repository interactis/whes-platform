<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ProfileItem */

$this->title = Yii::t('app', 'Create Profile Item');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Profile Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
