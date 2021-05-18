<?php

/* @var $this yii\web\View */

$this->title = $model->title;

$this->params['breadcrumbs'][] = ['label' => $heritage->short_name, 'url' => ['/heritage/view', 'slug' => $heritage->slug]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">

	<?= Yii::$app->controller->renderPartial('//common/_jumbotron', ['models' => $model->content->media]) ?>

	<?= $this->render('_info.php', ['model' => $model, 'heritage' => $heritage]) ?>

</div>
