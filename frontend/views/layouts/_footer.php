<?php
use yii\helpers\Html;
?>

<footer id="footer">
    <div class="container <?= Yii::$app->params['frontendType'] ?>">
    	<a class="footer-brand" href="/">
			<?= $this->render('_svg/logo.php', ['inverted' => true]) ?>
		</a>
		
		<div class="row">
    		<div class="col-lg-7 col-xl-6">
				<?= $this->render('_newsletter') ?>
			</div>
		</div>

		<div class="row closing-row">
			<?php if (Yii::$app->params['frontendType'] == 'visitor'): ?>
				<div class="col-xl-7 order-xl-2 partners">
					<a href="<?= Yii::t('app', 'https://www.myswitzerland.com/en-ch/destinations/attractions/unseco-world-heritage-sites/') ?>" class="img-link" target="_blank">
						<img class="switzerland-partner" src="/img/layout/logos/Switzerland_Partner.png">
					</a>
					<a href="<?= Yii::t('app', 'https://www.stnet.ch/de/swisstainable/') ?>" class="spacer" target="_blank">
						<img class="swisstainable" src="/img/layout/logos/swisstainable.png">
					</a>
					<a href="https://www.travelswitzerland.com" target="_blank">
						<img class="travel-switzerland" src="/img/layout/logos/Travel_Switzerland.png">
					</a>
				</div>
			<?php endif; ?>
			
			<div class="col-xl-5 small">
				<div class="social-links">
					<a href="https://www.instagram.com/worldheritageswitzerland/" target="_blank" title="<?= Yii::t('app', 'Follow us on {socialMedia}', ['socialMedia' => 'Instagram']) ?>"><i class="fa fa-instagram"></i></a>
					<a href="https://www.facebook.com/worldheritageswitzerland/" target="_blank" title="<?= Yii::t('app', 'Follow us on {socialMedia}', ['socialMedia' => 'Facebook']) ?>"><i class="fa fa-facebook-square"></i></a>
					<a href="https://www.youtube.com/user/UDSwitzerland" target="_blank" title="<?= Yii::t('app', 'Follow us on {socialMedia}', ['socialMedia' => 'YouTube']) ?>"><i class="fa fa-youtube-square"></i></a>
					<a href="https://www.pinterest.ch/worldheritageswitzerland/" target="_blank" title="<?= Yii::t('app', 'Follow us on {socialMedia}', ['socialMedia' => 'Pinterest']) ?>"><i class="fa fa-pinterest-square"></i></a>
					<a href="https://www.linkedin.com/company/world-heritage-experience-switzerland-whes/" target="_blank" title="<?= Yii::t('app', 'Follow us on {socialMedia}', ['socialMedia' => 'LinkedIn']) ?>"><i class="fa fa-linkedin-square"></i></a>
				</div>
			
				<?= Html::a(Yii::t('app', 'About us'), Yii::t('app', '/article/world-heritage-experience-switzerland-whes')) ?> &middot; 
				<?= Html::a(Yii::t('app', 'Media'), Yii::t('app', '/article/media-corner')) ?> &middot; 
				
				<?php
				if (Yii::$app->params['frontendType'] == 'visitor')
					echo Html::a('Trade', Yii::t('app', '/article/trade-corner')) .'&middot;';
				?>
				
				<?= Html::a('Impressum', '/impressum') ?> &middot; 
				<?= Html::a(ucfirst(Yii::t('app', 'privacy policy')), Yii::t('app', '/privacy')) ?> &middot;
				<?= Html::a(Yii::t('app', 'Contact'), Yii::t('app', '/contact')) ?>
			</div>
		</div>
    </div>
</footer>
