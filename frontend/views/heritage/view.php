<?php

/* @var $this yii\web\View */

$this->title = $model->short_name;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">

	<?= Yii::$app->controller->renderPartial('//common/_jumbotron') ?>

	<?= $this->render('_intro.php', ['model' => $model]) ?>

    
</div>