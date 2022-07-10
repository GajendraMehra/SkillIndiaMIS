<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Rate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rate-form col-md-8">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'rate_name')->textInput() ?>

  

    <div class="form-group text-right">
        <?php $btnName=($model->isNewRecord)?"Create":"Update" ?>
        <?= Html::a('Cancel', ['/rate/index'], ['class'=>'btn btn-info grid-button']) ?>
        <?= Html::submitButton(Yii::t('app', $btnName), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
