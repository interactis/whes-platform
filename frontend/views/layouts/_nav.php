<nav class="navbar navbar-expand-lg navbar-light bg-light">
  
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-nav" aria-controls="main-nav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="main-nav">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item active">
				<a class="nav-link" href="/">
					<?= Yii::t('app', 'Discover') ?>
				</a>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="heritagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<?= Yii::t('app', 'Heritages') ?>
				</a>
				<div class="dropdown-menu" aria-labelledby="heritagesDropdown">
					<a class="dropdown-item" href="#">Swiss Alps Jungfrau-Aletsch</a>
				</div>
			</li>
		</ul>
		<ul class="navbar-nav">
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="langDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					EN
				</a>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="langDropdown">
					<a class="dropdown-item" href="#">DE</a>
					<a class="dropdown-item active" href="#">EN</a>
					<a class="dropdown-item" href="#">FR</a>
					<a class="dropdown-item" href="#">IT</a>
				</div>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<?= Yii::t('app', 'Search') ?>
				</a>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="searchDropdown">
					<a class="dropdown-item" href="#">Swiss Alps Jungfrau-Aletsch</a>
				</div>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#"><?= Yii::t('app', 'My Collection') ?></a>
			</li>
		</ul>
		</div>
</nav>
