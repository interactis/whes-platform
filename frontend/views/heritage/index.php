<?php

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Our Heritage');

$this->params['breadcrumbs'][] = 'Swiss Alps Jungfrau-Aletsch';
?>
<div class="site-index">

	<?= Yii::$app->controller->renderPartial('//common/_jumbotron') ?>

	<?= $this->render('_intro.php') ?>

    
</div>
