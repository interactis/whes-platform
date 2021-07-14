<?php

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Our Heritage');
?>
<div class="site-index">

	<?= $this->render('/common/_jumbotron', ['models' => $media]) ?>

	<?= $this->render('_intro', ['model' => $model]) ?>
	
	<?= $this->render('/common/_filter', ['content' => $content, 'filters' => $filters]) ?>
	
	<?php // $this->render('_instaFeed') ?>
    
</div>
