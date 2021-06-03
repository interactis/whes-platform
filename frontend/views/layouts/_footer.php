<?php
use yii\helpers\Html;
use common\models\Heritage;

$heritages = Heritage::getActiveHeritages();
$count = count($heritages);
$half = ceil($count/2);
?>

<footer id="footer">
    <div class="container">
    	<div class="margin-bottom-md">
			<a class="footer-brand" href="/">
				<?= $this->render('_svg/logo.php', ['inverted' => true]) ?>
			</a>
		</div>
		
		<div class="row margin-bottom-lg">
			<div class="col-md-6">
				<ul class="list-unstyled">
					<?php
					for ($i = 0; $i <= $half-1; $i++)
					{
						echo $this->render('_footerHeritageLink.php', ['heritage' => $heritages[$i]]);
					}
					?>
				</ul>
			</div>
			<div class="col-md-6">
				<ul class="list-unstyled">
					<?php
					for ($i = $i; $i <= $count-1; $i++)
					{
						echo $this->render('_footerHeritageLink.php', ['heritage' => $heritages[$i]]);
					}
					?>
				</ul>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-6 order-md-2 social-links">
				<a href="https://www.instagram.com/worldheritageswitzerland/" target="_blank" title="<?= Yii::t('app', 'Follow us on {socialMedia}', ['socialMedia' => 'Instagram']) ?>"><i class="fa fa-instagram"></i></a>
				<a href="https://www.facebook.com/worldheritageswitzerland/" target="_blank" title="<?= Yii::t('app', 'Follow us on {socialMedia}', ['socialMedia' => 'Facebook']) ?>"><i class="fa fa-facebook-square"></i></a>
				<a href="https://www.youtube.com/user/UDSwitzerland" target="_blank" title="<?= Yii::t('app', 'Follow us on {socialMedia}', ['socialMedia' => 'YouTube']) ?>"><i class="fa fa-youtube-square"></i></a>
			</div>
			<div class="col-md-6 small">
				<?= Html::a('About', ['site/about']) ?> &middot; 
				<?= Html::a('Legal Terms', ['site/legal-terms']) ?> &middot;
				<?= Html::a('Contact', ['site/contact']) ?>
			</div>
		</div>
    </div>
</footer>