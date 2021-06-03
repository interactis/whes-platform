<?php
use yii\helpers\Html;
?>

<li class="heritage-li">
	<?= Html::a($heritage->name, ['heritage/view', 'slug' => $heritage->slug]) ?>
</li>