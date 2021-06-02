<?php
use yii\helpers\Url;

$url = Url::toRoute(['heritage/view', 'slug' => $model->slug]);
$img = $model->previewImage;
?>

<a class='img-link' href='<?= $url ?>'>
	<img class='img-fluid' src='<?= $img['url'] ?>'>
</a>
<div class='h4'>
	<a href='<?= $url ?>'><?= $model->short_name ?></a>
</div>
<a href='<?= $url ?>'>
	<i class='fa fa-chevron-right'></i> 
	<?= Yii::t('app', 'Learn more') ?>
</a>
