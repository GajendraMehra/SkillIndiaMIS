<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\OrganisationType;
use kartik\daterange\DateRangePicker;
use app\models\TpartnerDetail;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\TpartnerInvoice */
/* @var $form ActiveForm */
?>
<div class="tpartner-form-form2 mt-4">
    <?php 
       $validationUrl = ['tpartner/validate'];
       if (!$model->isNewRecord)
           // if the current record xis not new, we will pass "id" for validation in update action.
           $validationUrl['id'] = $model->id;
       ?>
           <?php $form = ActiveForm::begin([
           'id' => 'tpform-2',
           'action' => ['tpartner/ajax-test'],
           'enableAjaxValidation' => true,
           'validationUrl' => $validationUrl
       ]); ?>
     


        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'orgtype_id')->widget(Select2::classname(), [
                    'data' =>   ArrayHelper::map(OrganisationType::find()->all(), 'id', 'type_name'),
                    'options' => ['placeholder' => 'Select Organisation Type ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
               
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'org_id')->textInput([ 'class' => 'text-uppercase']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
            <?= $form->field($model, 'pan')->textInput([ 'class' => 'text-uppercase'])  ?>
            </div>
            <div class="col-md-6">
            <?= $form->field($model, 'tan')->textInput([ 'class' => 'text-uppercase'])  ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
            <?= $form->field($model, 'smart_id') ?>
            </div>
            <div class="col-md-6">

            <?= $form->field($model, 'reg_date')->textInput(['type' => 'date']);?>

            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
          
            </div>
           
        </div>
        <?= $form->field($model, 'id')->hiddenInput(['value'=> $model->id])->label(false); ?>

       
      
     
     
   
       
    
      
    <?php ActiveForm::end(); ?>

</div><!-- tpartner-form-form2 -->
