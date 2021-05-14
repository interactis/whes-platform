<nav class="navbar navbar-expand-lg navbar-light bg-light">
	
	<a class="navbar-brand" href="/">
		<?= $this->render('_svg/logo.php') ?>
	</a>
  	
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-nav" aria-controls="main-nav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	
	<div class="dropdown lang-mobile-dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="langMobileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			EN
		</a>
		<div class="dropdown-menu dropdown-menu-right language-mobile-dropdown-menu" aria-labelledby="langMobileDropdown">
			<a class="dropdown-item" href="#">Deutsch</a>
			<a class="dropdown-item active" href="#">English</a>
			<a class="dropdown-item" href="#">Français</a>
			<a class="dropdown-item" href="#">Italiano</a>
		</div>
	</div>

	<div class="collapse navbar-collapse" id="main-nav">
		<ul class="navbar-nav navbar-nav-left mr-auto">
			<li class="nav-item active">
				<a class="nav-link" href="/">
					<?= $this->render('_svg/discover.php') ?>
					<?= Yii::t('app', 'Discover') ?>
				</a>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="heritagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<?= $this->render('_svg/heritage.php') ?>
					<?= Yii::t('app', 'Heritages') ?>
				</a>
				<div class="dropdown-menu" aria-labelledby="heritagesDropdown">
					<a class="dropdown-item" href="#">Swiss Alps Jungfrau-Aletsch</a>
				</div>
			</li>
		</ul>
		<ul class="navbar-nav navbar-nav-right">
			<li class="nav-item dropdown lang-dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="langDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					EN
				</a>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="langDropdown">
					<a class="dropdown-item" href="#">Deutsch</a>
					<a class="dropdown-item active" href="#">English</a>
					<a class="dropdown-item" href="#">Français</a>
					<a class="dropdown-item" href="#">Italiano</a>
				</div>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<?= $this->render('_svg/search.php') ?>
					<?= Yii::t('app', 'Search') ?>
				</a>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="searchDropdown">
					<?= $this->render('_search.php') ?>
				</div>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">
					<?= $this->render('_svg/rucksack.php') ?>
					<?= Yii::t('app', 'My Collection') ?>
				</a>
			</li>
		</ul>
		</div>
</nav>
