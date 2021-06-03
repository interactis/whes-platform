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
		
		<div class="row margin-bottom-md">
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
		
		
		
    </div>
</footer>