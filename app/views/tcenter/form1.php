<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model1 app\models\TcenterAddress */
/* @var $form ActiveForm */
?>
<div class="tcenter-form1">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model1, 'address_line') ?>
        <?= $form->field($model1, 'post_office') ?>
        <?= $form->field($model1, 'pin_code') ?>
        <?= $form->field($model1, 'state_id') ?>
        <?= $form->field($model1, 'city_id') ?>
        <?= $form->field($model1, 'created_at') ?>
        <?= $form->field($model1, 'updated_at') ?>
        <?= $form->field($model1, 'edited_by') ?>
        <?= $form->field($model1, 'tp_id') ?>
        <?= $form->field($model1, 'village') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- tcenter-form1 -->
