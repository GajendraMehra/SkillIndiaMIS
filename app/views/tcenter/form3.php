<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TcenterSpocoperation */
/* @var $form ActiveForm */
?>
<div class="tcenter-form3">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'gender') ?>
        <?= $form->field($model, 'designation') ?>
        <?= $form->field($model, 'aadhar_no') ?>
        <?= $form->field($model, 'mobile_no') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'created_at') ?>
        <?= $form->field($model, 'updated_at') ?>
        <?= $form->field($model, 'edited_by') ?>
        <?= $form->field($model, 'tp_id') ?>
        <?= $form->field($model, 'landline_no') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- tcenter-form3 -->
