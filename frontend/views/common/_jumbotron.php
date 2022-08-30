<?php
use yii\widgets\Breadcrumbs;

$class = "";
if (isset($parallax) && $parallax)
	$class = 'parallax';

if (!isset($showCaption))
	$showCaption = true;
?>

<div id="top-carousel" class="jumbotron carousel fade-in slide <?= $class ?>" data-ride="carousel" data-touch="true">

	<div class="carousel-inner">
		
		<?php
		$i = 0;
		foreach($models as $i => $model):
			$imgUrl = $model->getImageUrl(1600);
			?>
			<div class="carousel-item <?=  ($i == 0) ? 'active' : ''; ?>">
				<img class="hidden" src="<?= $imgUrl ?>" alt="<?= $model->title ?>"> <?php // preload images ?>
				<div class="img-bg" style="background-image: url('<?= $imgUrl ?>');"></div>
				
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
		<?php endforeach; ?>
		
		<?php if ($i > 0): ?>
			<a class="carousel-control-prev img-link ignore-modal" href="#top-carousel" role="button" data-slide="prev">
				<span class="carousel-control-prev-icon ignore-modal" aria-hidden="true"></span>
				<span class="sr-only ignore-modal">Previous</span>
			</a>
			<a class="carousel-control-next img-link ignore-modal" href="#top-carousel" role="button" data-slide="next">
				<span class="carousel-control-next-icon ignore-modal" aria-hidden="true"></span>
				<span class="sr-only ignore-modal">Next</span>
			</a>
		<?php endif; ?>
		
	</div>
	
	<div class="footer">
		<div class="transition"></div>
	</div>
	
	<?php if (isset($content)): ?>
		<div class="container action-container">
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
