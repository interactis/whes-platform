<?php
use yii\helpers\Html;

$policyLink = Html::a(Yii::t('app', 'privacy policy'), ['site/privacy-policy']);

if (!isset(Yii::$app->request->cookies['okCookie'])): ?>
	<div id="cookie-info" class="mice-page">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-lg-9">
					<p><small><?= Yii::t('app', 'This website uses cookies to provide the best possible service. By continuing to browse the site you agree to our {link}.', ['link' => $policyLink]) ?></small></p>
				</div>
				<div class="col-md-4 col-lg-3">
					<?= Html::a('<span>Okay</span>', ['site/cookie', 'ok' => 1], ['class' => 'btn btn-primary btn-block']) ?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
