<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = Yii::t('app', "Oops, this page doesn't exist.");
?>
<div class="site-error">
	<div class="section no-jumbotron">
	   <div class="section-wrapper">  
			 <header class="container">
				<div class="row">
				   	<div class="col-md-6">
						<h1 class="margin-bottom-md">
							<?= $this->title ?>
						</h1>
				   	</div>
				</div>
			 </header>
			 <div class="container">
				<a href="/" class="btn btn-primary">
					<span><?= Yii::t('app', 'To the homepage') ?></span>
				</a>
			</div>
		</div>
	</div>
</div>
