<?php

use yii\helpers\Html;

$type = $content->types[$content->type];
$contentModel = $content->{$type};

$this->title = Yii::t('app', 'Update Audio');
$this->params['breadcrumbs'][] = ['label' => $contentModel->pluralName(), 'url' => [$type .'/index']];
$this->params['breadcrumbs'][] = ['label' => $contentModel->title, 'url' => [$type .'/update', 'id' => $contentModel->id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Audios'), 'url' => ['index', 'id' => $content->id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="audio-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
