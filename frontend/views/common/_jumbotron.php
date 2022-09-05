<?php
use yii\widgets\Breadcrumbs;

$class = "";
if (isset($parallax) && $parallax)
	$class = 'parallax';

if (!isset($showCaption))
	$showCaption = true;
?>

<div id="top-carousel" class="jumbotron carousel fade-in slide <?= $class ?>" data-ride="carousel" data-touch="true" data-interval="10000">

	<div class="carousel-inner">
		<?php
		$i = 0;
		$count = count($models);
		foreach($models as $i => $model):
			$imgUrl = $model->getImageUrl(1600);
			?>
			<div class="carousel-item <?=  ($i == 0) ? 'active' : ''; ?>">
				<div class="img-container">
					<img class="hidden" src="<?= $imgUrl ?>" alt="<?= $model->title ?>"> <?php // preload images ?>
					<div class="img-bg scale-image" style="background-image: url('<?= $imgUrl ?>');"></div>
					<?php if ($count > 1): ?>
						<a class="carousel-control-prev img-link ignore-modal" href="#top-carousel" role="button" data-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="sr-only">Previous</span>
						</a>
						<a class="carousel-control-next img-link ignore-modal" href="#top-carousel" role="button" data-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="sr-only">Next</span>
						</a>
					<?php endif; ?>
					<div class="carousel-caption">
						<div class="container">
							<div class="caption">
								<?php
								if ($showCaption && !empty($model->description))
									echo $model->description;
								?>
				
								<?php if (!empty($model->copyright)): ?>
									<div class="thin copyright">&copy; <?= $model->copyright ?></div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	
	<div class="footer ignore-modal">
		<div class="transition"></div>
	</div>
	
	<?php if (isset($content)): ?>
		<div class="container action-container ignore-modal">
			<div class="row">
				<div class="col-lg-4 offset-lg-8">
					<div class="action">
						<?= $this->render('_rucksackButton', ['model' => $content, 'largeBtn' => true]) ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	
</div>

<div class="container">
	<?= Breadcrumbs::widget([
		'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
	]) ?>
</div>

<?= $this->render('_imageModal', ['models' => $models]) ?>
