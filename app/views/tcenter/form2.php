<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TcenterBank */
/* @var $form ActiveForm */
?>
<div class="tcenter-form2">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'account_number') ?>
        <?= $form->field($model, 'ifsc_code') ?>
        <?= $form->field($model, 'bank_name') ?>
        <?= $form->field($model, 'account_name') ?>
        <?= $form->field($model, 'created_at') ?>
        <?= $form->field($model, 'updated_at') ?>
        <?= $form->field($model, 'edited_by') ?>
        <?= $form->field($model, 'tp_id') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- tcenter-form2 -->
