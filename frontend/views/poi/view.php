<?php

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Our Heritage');

$this->params['breadcrumbs'][] = ['label' => 'Swiss Alps Jungfrau-Aletsch', 'url' => ['/heritage/view']];
$this->params['breadcrumbs'][] = 'Jungfraujoch';
?>
<div class="site-index">

	<?= Yii::$app->controller->renderPartial('//common/_jumbotron') ?>

	<?= $this->render('_intro.php') ?>

    
</div>
