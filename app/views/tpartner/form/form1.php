<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
?>
<div class="tpartner-form-form1 mt-4 col-md-8">
<?php 
// Fixing the unique validation on update action
$validationUrl = ['tpartner/validate'];
if (!$model->isNewRecord)
    // if the current record xis not new, we will pass "id" for validation in update action.
    $validationUrl['id'] = $model->id;
?>
    <?php $form = ActiveForm::begin([
    'id' => 'tpform-1',
    'action' => ['tpartner/ajax-test'],
    'enableAjaxValidation' => true,
    'validationUrl' => $validationUrl
]); ?>
        <?= $form->field($model, 'tp_name')->textInput() ?>
        <?= $form->field($model, 'tp_sdms_id') ?>
        <?= $form->field($model, 'has_gst')->widget(Select2::classname(), [
                    'data' =>  ['No','Yes'],
                    'options' => ['placeholder' => 'Select GST Status...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Do you have GST'); ?>
        <?= $form->field($model, 'gst_no') ?>
        <?= $form->field($model, 'id')->hiddenInput(['value'=> $model->id])->label(false); ?>
      

    
       
    <?php ActiveForm::end(); ?>

</div><!-- tpartner-form-form2 -->
