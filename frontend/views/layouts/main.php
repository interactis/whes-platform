<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?= $this->render('_tracking') ?>
</head>
<body>
<?php $this->beginBody() ?>

<?= $this->render('_nav') ?>

<div class="page <?= Yii::$app->params['frontendType'] ?>">
	<?= $content ?>
</div>


<?php
if ($this->context->id != 'map')
	echo $this->render('_footer');
?>

<?= $this->render('_cookieMessage') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
