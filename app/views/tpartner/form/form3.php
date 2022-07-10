<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;

?>
<div class="tpartner-form-form3 mt-4">

<?php

$validationUrl = ['tpartner/validate'];
if (!$model->isNewRecord)
    // if the current record xis not new, we will pass "id" for validation in update action.
    $validationUrl['id'] = $model->id;

$form = ActiveForm::begin([
    'id' => 'tpform-3',
    'action' => ['tpartner/ajax-test'],
    'enableAjaxValidation' => true,
    'validationUrl' => $validationUrl
]); ?>

        <?= $form->field($model, 'account_number')->textInput(['class' => 'numberOnly', 
        'onkeypress'=>'return onlyNumberKey(event)'
        ])
        ?>
        <?= $form->field($model, 'id')->hiddenInput(['value'=> $model->id])->label(false); ?>
        <?= $form->field($model, 'account_name')->textInput([ 'class' => 'text-uppercase']) ?>
        <?= $form->field($model, 'bank_name')->textInput([ 'class' => 'text-uppercase']) ?>
        <?= $form->field($model, 'ifsc_code')->textInput([ 'class' => 'text-uppercase']) ?>
      
 
    <?php ActiveForm::end(); ?>

</div><!-- tpartner-form-form3 -->
<script>


</script>