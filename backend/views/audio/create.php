<?php

use yii\helpers\Html;

$type = $content->types[$content->type];
$contentModel = $content->{$type};

$this->title = Yii::t('app', 'Create Audio');
$this->params['breadcrumbs'][] = ['label' => $contentModel->pluralName(), 'url' => [$type .'/index']];
$this->params['breadcrumbs'][] = ['label' => $contentModel->title, 'url' => [$type .'/update', 'id' => $contentModel->id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Audio'), 'url' => ['index', 'id' => $content->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="audio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
