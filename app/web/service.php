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
        <h4 class="text-center">Training Partner Details</h4>
      </div>
      <hr>
      <form onsubmit="return false;" data-toggle="validator" action="#" method="POST role=" form" id="tpform-1">
        <div class="row">
          <div class="col-8">
            <div class="form-group has-success mt-1">
              <label for="cc-name" class=" font-weight-bold  control-label font-weight-bold mb-1">Training Partner
                Name</label>
              <input id="cc-name" name="cc-name" type="text" class="form-control cc-name valid" data-val="true"
                data-val-required="Please enter the name on card" autocomplete="cc-name" aria-required="true"
                aria-invalid="false" aria-describedby="cc-name-error" required>
              <div class="help-block with-errors text-danger mt-1"></div>
            </div>
          </div>
        </div>


        <div class="row">
          <div class="col-8">
            <label for="x_card_code" class=" font-weight-bold  control-label mb-1">TP SDMS ID (Account ID) </label>
            <div class="form-group   has-feedback mt-1 ">
              <input id="cc-name" name="cc-name" type="text" class="form-control cc-name valid" data-val="true"
                data-val-required="Please enter the name on card" autocomplete="cc-name" aria-required="true"
                aria-invalid="false" aria-describedby="cc-name-error" required>
              <div class="help-block with-errors text-danger mt-1"></div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8 mt-2">
            <label for="x_card_code" class=" font-weight-bold  control-label mt-1">Has G.S.T </label>
            <div class="form-group">
              <select name="select" id="select" class="form-control" required>
                <option value="">Please select</option>
                <option value="1">Yes</option>
                <option value="2">No</option>
              </select>
              <div class="help-block with-errors text-danger mt-1"></div>


            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-8">
            <div class="form-group mt-2">
              <label for="cc-name" class=" font-weight-bold  control-label mt-1">GST Number</label>
              <input id="cc-name" name="cc-name" type="text" class="form-control cc-name valid" data-val="true"
                data-val-required="Please enter the name on card" autocomplete="cc-name" aria-required="true"
                aria-invalid="false" aria-describedby="cc-name-error" required>
              <div class="help-block with-errors text-danger mt-1"></div>

            </div>
          </div>
        </div>
        <div class="form-group">

        </div>
      </form>
    </div>
  </div>';
  break;
  case '21':
    echo '<div id="pay-invoice">
      <div class="card-body">
        <div class="card-title">
          <h4 class="text-center">Training Partner Details</h4>
        </div>
        <hr>
        <form onsubmit="return false;" data-toggle="validator" action="#" method="POST role=" form" id="tpform-'.$step_number.'">
          <div class="row">
            <div class="col-8">
              <div class="form-group has-success mt-1">
                <label for="cc-name" class=" font-weight-bold  control-label font-weight-bold mb-1">Training Partner
                  Name</label>
                <input id="cc-name" name="cc-name" type="text" class="form-control cc-name valid" data-val="true"
                  data-val-required="Please enter the name on card" autocomplete="cc-name" aria-required="true"
                  aria-invalid="false" aria-describedby="cc-name-error" required>
                <div class="help-block with-errors text-danger mt-1"></div>
              </div>
            </div>
          </div>
  
  
          <div class="row">
            <div class="col-8">
              <label for="x_card_code" class=" font-weight-bold  control-label mb-1">TP SDMS ID (Account ID) </label>
              <div class="form-group   has-feedback mt-1 ">
                <input id="cc-name" name="cc-name" type="text" class="form-control cc-name valid" data-val="true"
                  data-val-required="Please enter the name on card" autocomplete="cc-name" aria-required="true"
                  aria-invalid="false" aria-describedby="cc-name-error" required>
                <div class="help-block with-errors text-danger mt-1"></div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8 mt-2">
              <label for="x_card_code" class=" font-weight-bold  control-label mt-1">Has G.S.T </label>
              <div class="form-group">
                <select name="select" id="select" class="form-control" required>
                  <option value="">Please select</option>
                  <option value="1">Yes</option>
                  <option value="2">No</option>
                </select>
                <div class="help-block with-errors text-danger mt-1"></div>
  
  
              </div>
            </div>
          </div>
  
          <div class="row">
            <div class="col-8">
              <div class="form-group mt-2">
                <label for="cc-name" class=" font-weight-bold  control-label mt-1">GST Number</label>
                <input id="cc-name" name="cc-name" type="text" class="form-control cc-name valid" data-val="true"
                  data-val-required="Please enter the name on card" autocomplete="cc-name" aria-required="true"
                  aria-invalid="false" aria-describedby="cc-name-error" required>
                <div class="help-block with-errors text-danger mt-1"></div>
  
              </div>
            </div>
          </div>
          <div class="form-group">
  
          </div>
        </form>
      </div>
    </div>';
    break;

  case '2':
    echo '<div id="pay-invoice">
      <div class="card-body">
        <div class="card-title">
          <h4 class="text-center">DATA REQUIRED FOR INVOICES AND PAYMENTS</h4>
        </div>
        <hr>
        <form onsubmit="return false;" data-toggle="validator" action="#" method="POST role=" form" id="tpform-'.$step_number.'">
          <div class="row">
            <div class="col-md-6 col-sm-12">
                <label for="x_card_code" class=" font-weight-bold  control-label mt-1">Organization Type</label>
                <div class="form-group">
                <select name="select" id="select" class="form-control" required>
                  <option value="">Please select</option>
                  <option value="1">Registered Private Limited Company</option>
                  <option value="2">Other</option>
                </select>
                
                <div class="help-block with-errors text-danger mt-1"></div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <label for="x_card_code" class=" font-weight-bold  control-label mt-1">Organization Identifier</label>

                <div class="form-group">
                <input id="org-id" name="org-id"  data-minlength="6" type="text" class="form-control valid" required>
                
                <div class="help-block with-errors text-danger mt-1"></div>
                </div>
            </div>
            </div>
          

          <div class="row">
            <div class="col-md-6 col-sm-12">
              <label for="x" class=" font-weight-bold  control-label mt-1">PAN</label>

              <div class="form-group">
              <input id="pan-id" name="pan-id"  type="text" class="form-control valid" required>
              
              <div class="help-block with-errors text-danger mt-1"></div>
              </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <label for="x" class=" font-weight-bold  control-label mt-1">TAN</label>

              <div class="form-group">
              <input id="tan-id" name="tan-id"  type="text" class="form-control valid" required>
              
              <div class="help-block with-errors text-danger mt-1"></div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 col-sm-12">
            <label for="x" class=" font-weight-bold  control-label mt-1">SMART TP ID</label>

            <div class="form-group">
            <input id="smart-id" name="smart-id"  type="text" class="form-control valid" required>
            
            <div class="help-block with-errors text-danger mt-1"></div>
            </div>
            </div>
            <div class="col-md-6 col-sm-12">
            <label for="x_card_code" class=" font-weight-bold  control-label mt-1">Status</label>
                <div class="form-group">
                <select name="select" id="select" class="form-control" required>
                  <option value="">Please select</option>
                  <option value="1">Active</option>
                  <option value="2">Inactive</option>
                </select>
                
                <div class="help-block with-errors text-danger mt-1"></div>
                </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 col-sm-12">
            <label for="x" class=" font-weight-bold  control-label mt-1">Company Registration Date</label>

            <div class="form-group">
            <input id="regdate" name="regdate"  type="date" class="form-control valid" required>
            
            <div class="help-block with-errors text-danger mt-1"></div>
            </div>
            </div>
            <div class="col-md-6 col-sm-12"></div>
          </div>
        </form>
      </div>
    </div>';
    break;
  


  case '4':
    echo '<div id="pay-invoice">
      <div class="card-body">
        <div class="card-title">
          <h4 class="text-center">DATA REQUIRED FOR INVOICES AND PAYMENTS</h4>
        </div>
        <hr>
        <form onsubmit="return false;" data-toggle="validator" action="#" method="POST role=" form" id="tpform-'.$step_number.'">
          <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="form-group">
                <select name="select" id="select" class="form-control" required>
                  <option value="">Please select</option>
                  <option value="1">Yes</option>
                  <option value="2">No</option>
                </select>
                </div>
                <div class="help-block with-errors text-danger mt-1"></div>


          
            </div>
            <div class="col-md-6 col-sm-12">
            
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 col-sm-12">
            
            </div>
            <div class="col-md-6 col-sm-12">
            
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 col-sm-12">
            
            </div>
            <div class="col-md-6 col-sm-12"></div>
          </div>

          <div class="row">
            <div class="col-md-6 col-sm-12"></div>
            <div class="col-md-6 col-sm-12"></div>
          </div>
        </form>
      </div>
    </div>';
    break;
  
  

  case '3':
    echo '<div id="pay-invoice">
      <div class="card-body">
        <div class="card-title">
          <h4 class="text-center">BANK DETAILS</h4>
        </div>
        <hr>
        <form onsubmit="return false;" data-toggle="validator" action="#" method="POST role=" form" id="tpform-'.$step_number.'">
          <div class="row">
            <div class="col-md-6 col-sm-12">
            <label for="x_card_code" class=" font-weight-bold  control-label mt-1">Bank Account Number</label>

            <div class="form-group">
            <input id="org-id" name="org-id"  data-minlength="6" type="text" class="form-control valid" required>
            
            <div class="help-block with-errors text-danger mt-1"></div>
            </div>
            </div>
            <div class="col-md-6 col-sm-12">
            <label for="x_card_code" class=" font-weight-bold  control-label mt-1">Bank Account Number</label>

            <div class="form-group">
            <input id="org-id" name="org-id"  data-minlength="6" type="text" class="form-control valid" required>
            
            <div class="help-block with-errors text-danger mt-1"></div>
            </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 col-sm-12">
            <label for="x_card_code" class=" font-weight-bold  control-label mt-1">Bank Name</label>

            <div class="form-group">
            <input id="org-id" name="org-id"  data-minlength="6" type="text" class="form-control valid" required>
            
            <div class="help-block with-errors text-danger mt-1"></div>
            </div>

            </div>
            <div class="col-md-6 col-sm-12">
            <label for="x_card_code" class=" font-weight-bold  control-label mt-1">Account Holder Name as on Bank </label>

            <div class="form-group">
            <input id="org-id" name="org-id"  data-minlength="6" type="text" class="form-control valid" required>
            
            <div class="help-block with-errors text-danger mt-1"></div>
            </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 col-sm-12">
            
            </div>
            <div class="col-md-6 col-sm-12"></div>
          </div>

          <div class="row">
            <div class="col-md-6 col-sm-12"></div>
            <div class="col-md-6 col-sm-12"></div>
          </div>
        </form>
      </div>
    </div>';
    break;
  
  default:
  // $this->render('service.php')
  header('Location: index.php');
  ?>
       
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
