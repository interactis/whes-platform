<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Flag */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="flag-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'flag_group_id')->textInput() ?>

    <?= $form->field($model, 'hidden')->checkbox() ?>

    <?= $form->field($model, 'order')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
