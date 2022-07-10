<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-form col-md-8">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    <?= (!$model->username) ? $form->field($model, 'password')->textInput(['maxlength' => true,"type"=>"password"]) : '' ?>
    <?= ($model->username) ?  $form->field($model, 'status')->widget(Select2::classname(), [
        'data' =>   array('10' => 'Active','9'=> 'Deactive' ),
        'options' => ['placeholder' => 'Select Status...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) : '' ?>





    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>



    <div class="form-group text-right">
      <?php $btnName=(!$model->username)?"Create":"Update" ?>
        <?= Html::submitButton($btnName, ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
