<?php
use yii\helpers\Html;

$currentLang = strtoupper(Yii::$app->language);

$langLinks = [
	Html::a('Deutsch', ['site/language', 'lang' => 'de'], ['class' => (Yii::$app->language == 'de' ? 'active ' : '') .'dropdown-item']),
	Html::a('English', ['site/language', 'lang' => 'en'], ['class' => (Yii::$app->language == 'en' ? 'active ' : '') .'dropdown-item']),
	Html::a('Français', ['site/language', 'lang' => 'fr'], ['class' => (Yii::$app->language == 'fr' ? 'active ' : '') .'dropdown-item']),
	Html::a('Italiano', ['site/language', 'lang' => 'it'], ['class' => (Yii::$app->language == 'it' ? 'active ' : '') .'dropdown-item'])
];
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
	
	<a class="navbar-brand" href="/">
		<?= $this->render('_svg/logo.php') ?>
	</a>
  	
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-nav" aria-controls="main-nav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	
	<div class="dropdown lang-mobile-dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="langMobileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<?= $currentLang ?>
		</a>
		<div class="dropdown-menu dropdown-menu-right language-mobile-dropdown-menu" aria-labelledby="langMobileDropdown">
			<?php foreach($langLinks as $link)
				echo $link;
			?>
		</div>
	</div>

	<div class="collapse navbar-collapse" id="main-nav">
		<ul class="navbar-nav navbar-nav-left mr-auto">
			<li class="nav-item <?= (($this->context->id == 'site' && $this->context->action->id == 'index') ? 'active' : '') ?>">
				<a class="nav-link" href="/">
					<?= $this->render('_svg/discover.php') ?>
					<?= Yii::t('app', 'Discover') ?>
				</a>
			</li>
			<li class="nav-item dropdown <?= (($this->context->id == 'heritage') ? 'active' : '') ?>">
				<a class="nav-link dropdown-toggle" href="#" id="heritagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<?= $this->render('_svg/heritage.php') ?>
					<?= Yii::t('app', 'Heritages') ?>
				</a>
				<div class="dropdown-menu" aria-labelledby="heritagesDropdown">
					<a class="dropdown-item" href="/heritage">Swiss Alps Jungfrau-Aletsch</a>
				</div>
			</li>
		</ul>
		<ul class="navbar-nav navbar-nav-right">
			<li class="nav-item dropdown lang-dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="langDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<?= $currentLang ?>
				</a>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="langDropdown">
					<?php foreach($langLinks as $link)
						echo $link;
					?>
				</div>
			</li>
			<li class="nav-item dropdown <?= (($this->context->id == 'search') ? 'active' : '') ?>">
				<a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<?= $this->render('_svg/search.php') ?>
					<?= Yii::t('app', 'Search') ?>
				</a>
				<div class="dropdown-menu dropdown-menu-right search-dropdown-menu" aria-labelledby="searchDropdown">
					<?= $this->render('_search.php') ?>
				</div>
			</li>
			<li class="nav-item <?= (($this->context->id == 'rucksack') ? 'active' : '') ?>">
				<a class="nav-link" href="#">
					<?= $this->render('_svg/rucksack.php') ?>
					<?= Yii::t('app', 'My Collection') ?>
				</a>
			</li>
		</ul>
		</div>
</nav>
