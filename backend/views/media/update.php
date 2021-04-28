<?php

use yii\helpers\Html;

$contentType = $model->contentType;
$contentModel = $model->{$contentType};

switch ($contentType)
{
	case 'heritage':
		$contentTitle = $contentModel->short_name;
		break;
	default:
		$contentTitle = $contentModel->title;
}

$this->title = Yii::t('app', 'Update Image');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Heritages'), 'url' => ['heritage/index']];
$this->params['breadcrumbs'][] = ['label' => $contentTitle, 'url' => [$contentType .'/update', 'id' => $contentModel->id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Images'), 'url' => ['media/heritage', 'id' => $contentModel->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="media-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
