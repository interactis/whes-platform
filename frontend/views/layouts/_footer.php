<?php
use yii\helpers\Html;
?>

<footer id="footer">
    <div class="container">
    
    	<div class="row">
    		<div class="col-lg-4">
				<a class="footer-brand" href="/">
					<?= $this->render('_svg/logo.php', ['inverted' => true]) ?>
				</a>
			</div>
			
			<?php if (Yii::$app->params['frontendType'] == 'visitor'): ?>
				<div class="col-lg-8 partners">
					<a href="<?= Yii::t('app', 'https://www.myswitzerland.com/en-ch/destinations/attractions/unseco-world-heritage-sites/') ?>" class="img-link" target="_blank">
						<img class="switzerland-tourism" src="/img/layout/logos/switzerland-tourism/<?= Yii::$app->language ?>.png">
					</a>
					<a href="<?= Yii::t('app', 'https://www.stnet.ch/de/swisstainable/') ?>" class="spacer" target="_blank">
						<img class="swisstainable" src="/img/layout/logos/swisstainable.png">
					</a>
					<a href="<?= Yii::t('app', 'https://www.mystsnet.com/en/') ?>" target="_blank">
						<img class="swiss-travel-system" src="/img/layout/logos/swiss-travel-system/<?= Yii::$app->language ?>.png">
					</a>
				</div>
			<?php endif; ?>
		</div>

		<div class="row closing-row">
			<div class="col-md-3 order-md-2 social-links">
				<a href="https://www.instagram.com/worldheritageswitzerland/" target="_blank" title="<?= Yii::t('app', 'Follow us on {socialMedia}', ['socialMedia' => 'Instagram']) ?>"><i class="fa fa-instagram"></i></a>
				<a href="https://www.facebook.com/worldheritageswitzerland/" target="_blank" title="<?= Yii::t('app', 'Follow us on {socialMedia}', ['socialMedia' => 'Facebook']) ?>"><i class="fa fa-facebook-square"></i></a>
				<a href="https://www.youtube.com/user/UDSwitzerland" target="_blank" title="<?= Yii::t('app', 'Follow us on {socialMedia}', ['socialMedia' => 'YouTube']) ?>"><i class="fa fa-youtube-square"></i></a>
				<a href="https://www.pinterest.ch/worldheritageswitzerland/" target="_blank" title="<?= Yii::t('app', 'Follow us on {socialMedia}', ['socialMedia' => 'Pinterest']) ?>"><i class="fa fa-pinterest-square"></i></a>
				<a href="https://www.linkedin.com/company/world-heritage-experience-switzerland-whes/" target="_blank" title="<?= Yii::t('app', 'Follow us on {socialMedia}', ['socialMedia' => 'LinkedIn']) ?>"><i class="fa fa-linkedin-square"></i></a>
			</div>
			<div class="col-md-9 small">
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
