<?php

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Our Heritage');
?>
<div class="site-index">

	<?= $this->render('/common/_jumbotron', ['models' => $media, 'showCaption' => false]) ?>

	<?= $this->render('_intro.php', ['model' => $model]) ?>
	
	<?= $this->render('_filter.php', ['model' => $model]) ?>
    
</div>
