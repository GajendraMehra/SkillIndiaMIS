<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\TpdetailSpocoperation */
/* @var $form ActiveForm */
?>
<div class="tpartner-form-form7 mt-4">

        <?php

        $validationUrl = ['tpartner/validate'];
        if (!$model->isNewRecord)
            // if the current record xis not new, we will pass "id" for validation in update action.
            $validationUrl['id'] = $model->id;

        $form = ActiveForm::begin([
            'id' => 'tpform-7',
            'action' => ['tpartner/ajax-test'],
            'enableAjaxValidation' => true,
            'validationUrl' => $validationUrl
        ]); ?>
        <div class="row">
        <div class="col-md-6">
        <div class="form-check">
            <input type="checkbox" class="form-check-input copyfromprevious" id="copyspoc" value="TpdetailSpocfinance" name="TpdetailSpocfinance[copyspoc]" >
            <label class="form-check-label mb-4" for="exampleCheck1">Same as <b>SPOC OPERATION</b></label>

        </div>
        </div>
        </div>
        <div class="row">
            <div class="col-md-6">
            <?= $form->field($model, 'name') ?>
            </div>
            <div class="col-md-6">
            <?= $form->field($model, 'gender')->widget(Select2::classname(), [
                    'data' =>  ['Female','Male','Other'],
                    'options' => ['placeholder' => 'Select Status...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
            <?= $form->field($model, 'designation') ?>
            </div>
            <div class="col-md-6">
            <?= $form->field($model, 'aadhar_no')->textInput(['class' => 'numberOnly', 'onkeypress'=>'return onlyNumberKey(event)' ])  ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
            <?= $form->field($model, 'mobile_no')->textInput(['class' => 'numberOnly', 
                'onkeypress'=>'return onlyNumberKey(event)'
                ]) 
            ?> 
            </div>
            <div class="col-md-6">
            <?= $form->field($model, 'email') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
            <?= $form->field($model, 'landline_no')->textInput(['class' => 'numberOnly', 
            'onkeypress'=>'return onlyNumberKey(event)'
            ]) ?>
            </div>
            <div class="col-md-6">
           
            </div>
        </div>
       
        <?= $form->field($model, 'id')->hiddenInput(['value'=> $model->id])->label(false); ?>

       
    <?php ActiveForm::end(); ?>

</div><!-- tpartner-form-form7 -->


