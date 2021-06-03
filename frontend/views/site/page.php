<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site">
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
			 <div class="container small">
			 	<div class="row">
			 		<div class="col-md-8 col-lg-7 col-xl-6">
						<?= $model->description ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>