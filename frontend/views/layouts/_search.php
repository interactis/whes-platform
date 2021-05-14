<?php
$q = '';
if (isset($_GET['q']))
	$q = $_GET['q'];
?>

<form action="/search" method="get">
	<div class="input-group mb-3">
		<input type="text" name="q" class="form-control search-field" placeholder="<?= Yii::t('app', 'Search') ?>" aria-label="<?= Yii::t('app', 'Search') ?>" value="<?= $q ?>">
		<div class="input-group-append">
			<button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i></button>
		</div>
	</div>
</form>
