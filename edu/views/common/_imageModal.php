<!-- Modal -->
<div class="modal fade image-modal" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModal" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-body">
				<a href="#" class="btn close-btn" data-dismiss="modal" title="<?= Yii::t('app', 'Close') ?> ">
					<i class="fa fa-close"></i>
				</a>
				<div id="img-modal-carousel" class="carousel slide" data-ride="carousel" data-touch="true" data-interval="false">
					<div class="carousel-inner">
						<?php
						$i = 0;
						$count = count($models);
						foreach($models as $i => $model): ?>
							<div class="carousel-item <?=  ($i == 0) ? 'active' : ''; ?>">
								<div class="img-container">
									<?= $model->getImageHtml(1600, 'd-block w-100', $model->title, 'filename', 'ratio') ?>
									<?php if ($count > 1): ?>
										<a class="carousel-control-prev img-link" href="#img-modal-carousel" role="button" data-slide="prev">
											<span class="carousel-control-prev-icon" aria-hidden="true"></span>
											<span class="sr-only">Previous</span>
										</a>
										<a class="carousel-control-next img-link" href="#img-modal-carousel" role="button" data-slide="next">
											<span class="carousel-control-next-icon" aria-hidden="true"></span>
											<span class="sr-only">Next</span>
										</a>
									<?php endif; ?>
								</div>
								<?php if (!empty($model->description)): ?>
									<div class="caption small">
										<?= $model->description; ?>
										<?php if (!empty($model->copyright)): ?>
											<div class="thin copyright">&copy; <?= $model->copyright ?></div>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
