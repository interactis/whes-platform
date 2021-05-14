<?php
use yii\widgets\Breadcrumbs;

$class = "";
if (isset($parallax) && $parallax)
	$class = 'parallax';
?>

<div id="top-carousel" class="jumbotron carousel slide <?= $class ?>" data-ride="carousel" data-touch="true">

	<div class="carousel-inner">
		
		<div class="carousel-item active">
			<div class="img-bg" style="background-image: url('/img/layout/_construction/sardona.jpg');"></div>
		</div>
		
		<div class="carousel-item">
			<div class="img-bg" style="background-image: url('/img/layout/_construction/saja.jpg');"></div>
		</div>
		
		<a class="carousel-control-prev img-link" href="#top-carousel" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="carousel-control-next img-link" href="#top-carousel" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
		
		<?php
		/*
		$i = 0;
		foreach($model->$contenfulField as $i => $image): ?>
			<div class="carousel-item <?=  ($i == 0) ? 'active' : ''; ?>">
				<img class="hidden" src="<?= \Yii::$app->helpers->getImgUrl($model, 1600, $contenfulField, $i) ?>"> <?php // preload images ?>
				<div class="img-bg" style="background-image: url('<?= \Yii::$app->helpers->getImgUrl($model, 1600, $contenfulField, $i) ?>');"></div>
			</div>
		<?php endforeach; ?>
		
		<?php if ($i > 0): ?>
			<a class="carousel-control-prev img-link" href="#top-carousel" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="carousel-control-next img-link" href="#top-carousel" role="button" data-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		<?php endif; ?>
		*/
		?>
	</div>
	
	<div class="footer">
		<div class="transition"></div>
		<div class="spacer"></div>
	</div>
</div>

<div class="container">
	<?= Breadcrumbs::widget([
		'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
	]) ?>
</div>
