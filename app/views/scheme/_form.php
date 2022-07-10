<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use app\models\Job;
// use app\models\TpartnerDetail;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\Scheme */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scheme-form col-md-8 ">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'short_name')->textInput() ?>

    <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

  
  
        
    
    <?= $form->field($model, 'description')->textArea(['maxlength' => true,'rows'=>3]) ?>


    <div class="form-group text-right">
    <?php $btnName=($model->isNewRecord)?"Create":"Update" ?>
        <?= Html::a('Cancel', ['/scheme/index'], ['class'=>'btn btn-info grid-button']) ?>
        <?= Html::submitButton(Yii::t('app', $btnName), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

