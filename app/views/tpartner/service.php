<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
// sleep(2);
$step_number = $_REQUEST["step_number"];

switch ($step_number) {
  case '1':
  echo '<div id="pay-invoice">
  <div class="card-body">
      <div class="card-title">
          <h3 class="text-center">Training Partner Details</h3>
      </div>
      <hr>
      <form action="" method="post" novalidate="novalidate">
          
       
              <div class="row">
                  <div class="col-8">
                    <div class="form-group has-success">
                    <label for="cc-name" class="control-label mb-1">Training Partner Name</label>
                    <input id="cc-name" name="cc-name" type="text" class="form-control cc-name valid" data-val="true" data-val-required="Please enter the name on card" autocomplete="cc-name" aria-required="true" aria-invalid="false" aria-describedby="cc-name-error">
                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name" data-valmsg-replace="true"></span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-8">
                      <label for="x_card_code" class="control-label mb-1">Security code</label>
                      <div class="input-group">
                          <input id="x_card_code" name="x_card_code" type="tel" class="form-control cc-cvc" value="" data-val="true" data-val-required="Please enter the security code" data-val-cc-cvc="Please enter a valid security code" autocomplete="off">
                          <div class="input-group-addon">
                          </div>
                      </div>
                  </div>
              </div>
      </form>
  </div>
</div>';
    break;
  
  default:
  echo "bye";?>
      <div class="form-group text-right">
  <?= "bye";?>
      
       
    </div>
<?php 

/* @var $this yii\web\View */
/* @var $model app\models\Scheme */
/* @var $form yii\widgets\ActiveForm */
//  Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>


<div class="scheme-form col-md-8">

    

</div>
    <?php 

    
  
  break;
}
?>
