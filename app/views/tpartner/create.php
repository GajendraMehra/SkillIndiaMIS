<!-- <script type="text/javascript" src="jquery-2.0.0.min.js"></script> -->

<?php 
$this->title = Yii::t('app', 'Approval Request');
// $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Schemes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
use app\models\TpartnerDetail;
use app\models\TpartnerInvoice;
use app\models\TpartnerBank;
use app\models\TpdetailSpocoperation;
use app\models\TpdetailSpocfinance;
use app\models\TpdetailCeo;
use app\models\TpdetailAddress;
?>
<!-- CSS -->
<link href="https://cdn.jsdelivr.net/npm/smartwizard@5/dist/css/smart_wizard_all.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/smartwizard@5/dist/js/jquery.smartWizard.min.js" type="text/javascript"></script>
<style>
    .content{
        /* width:100% !important; */
        /*height:100% !important; */
   height:100% !important;

    }
    .swMain ul.anchor li a.disabled {
    color: #272C33 !important;
  
}
.swMain .stepContainer div.content {
    
  
    width: 100% !important;
}

    .swMain {
    /* position: relative;
    display: block;
    margin: 0;
    padding: 0;
    border: 0px solid #CCC;
    overflow: visible; */
    float: none !important;
    width:100% !important;
   height:100% !important;

    }
    .swMain ul.anchor li a.selected {
	color: #F8F8F8;
	background: #E74C3C !important;
	border: 1px solid #8E5B1F;
	cursor: text;
	-moz-box-shadow: 1px 5px 10px #888;
	-webkit-box-shadow: 1px 5px 10px #888;
	box-shadow: 1px 5px 10px #888;
    }

    .stepContainer{
       height:100% !important;

    }
    .swMain ul.anchor li a.done {
    position: relative;
    color: #FFF;
    background: #28A745 !important;
    border: 1px solid #8CC63F;
    z-index: 99;
}
.stepNumber {
    position: relative;
    float: left;
    width: 30px;
    text-align: center;
    padding: 5px;
    padding-top: 0;
    font: bold 2em Verdana, Arial, Helvetica, sans-serif !important;
}
.swMain ul.anchor li a {
    height: 55px !important;
}

.stepContainer div.content{
    font-size:inherit !important;
}
.buttonNext{
    
    color: #fff !important;
    width:10em !important;
    background-color: #28a745 !important;
    border-color: #28a745 !important;
    /* padding:1em !important; */

}
.buttonPrevious{
    
    color: #fff !important;
    background-color: #28a745 !important;
    border-color: #28a745 !important;

}
</style>
<div class="row">
    <div class="col-md-12 col-xl-12">
    <input type="button"  id="erroralert" style="display:none" value="">

    <div id="wizard" class="swMain">
  <ul>
  <li><a href="#step-0">
          <label class="stepNumber"></label>
          <span class="stepDesc">
            
             Instruction
          </span>
      </a></li>
    <li><a href="#step-1">
          <label class="stepNumber">1</label>
          <span class="stepDesc">
            
             T.P DETAILS
          </span>
      </a></li>
    <li><a href="#step-2">
          <label class="stepNumber">2</label>
          <span class="stepDesc">
             PAYMENTS
          </span>
      </a></li>
    <li><a href="#step-3">
          <label class="stepNumber">3</label>
          <span class="stepDesc">
             BANK 
          </span>                   
       </a>
    </li>
    <!-- <li><a href="#step-4">
          <label class="stepNumber">4</label>
          <span class="stepDesc">
          Tax
          </span>                   
      </a>
    </li> -->
    <li><a href="#step-5">
          <label class="stepNumber">4</label>
          <span class="stepDesc">
          ADDRESS 
          </span>                   
      </a>
    </li>
    <li><a href="#step-6">
          <label class="stepNumber">5</label>
          <span class="stepDesc">
             SPOC
          </span>                   
      </a>
    </li>
    <li>
        <a href="#step-7">
          <label class="stepNumber">6</label>
          <span class="stepDesc">
          SPOCF  
          </span>                   
      </a>
    </li>
    <li>
        <a href="#step-8">
          <label class="stepNumber">7</label>
          <span class="stepDesc">
          CEO/MD
          </span>                   
      </a>
    </li>
    
  </ul>
  <div id="step-0">   
      <h4 class="StepTitle">Instruction</h4>
      <?php 
     
      echo $this->render('form/form0.php', [
       
    ]) ?>
  </div>
  <div id="step-1">   
      <h4 class="StepTitle">TRAINING PARTNER DETAILS</h4>
      <?php 
      $model=new TpartnerDetail();
      // $model->validate();
      
      $editedBy=$model->find()->where(['edited_by' => Yii::$app->user->identity->id])->one();
      if ($editedBy) {
        $model=$model->findOne($editedBy['id']);
      }
      echo $this->render('form/form1.php', [
        'model' => $model
    ]) ?>
  </div>
  <div id="step-2">
      <h4 class="StepTitle">DATA REQUIRED FOR INVOICES AND PAYMENTS</h4> 
      <?php 
      $model=new TpartnerInvoice();
      // $model->validate();
  
      $editedBy=$model->find()->where(['edited_by' => Yii::$app->user->identity->id])->one();
      if ($editedBy) {
        $model=$model->findOne($editedBy['id']);
      }
      echo $this->render('form/form2.php', [
        'model' => $model
    ]) ?>
  </div>                      
  <div id="step-3">
      <h4 class="StepTitle">BANK DETAILS</h4>   
      <?php 
      $model=new TpartnerBank();
      //  $model->validate();
      $editedBy=$model->find()->where(['edited_by' => Yii::$app->user->identity->id])->one();
      if ($editedBy) {
        $model=$model->findOne($editedBy['id']);
      }
      echo $this->render('form/form3.php', [
        'model' => $model
    ]) ?>
  </div>
  <!-- <div id="step-4">
      <h4 class="StepTitle">TAX EXEMPTION CERTIFICATE, IF ANY</h4>   
       <!-- step conten                     
  </div> -->
  <div id="step-5">
      <h4 class="StepTitle">ADDRESS DETAILS</h4>   
      <?php 
      $model=new TpdetailAddress();
        // $model->validate();
      $editedBy=$model->find()->where(['edited_by' => Yii::$app->user->identity->id])->one();
      if ($editedBy) {
        $model=$model->findOne($editedBy['id']);
      }
       
        echo $this->render('form/form5.php', [
          'model' => $model
      ]) ?>                 
  </div>
  <div id="step-6">
      <h4 class="StepTitle">SINGLE POINT OF CONTACT-OPERATION (SPOC-OPERATION)</h4>   
        
      <?php
      $model=new TpdetailSpocoperation();
          // $model->validate();
        $editedBy=$model->find()->where(['edited_by' => Yii::$app->user->identity->id])->one();
        if ($editedBy) {
          $model=$model->findOne($editedBy['id']);
        }
        echo $this->render('form/form6.php', [
          'model' => $model
      ]) ?>           
  </div>
  <div id="step-7">
      <h4 class="StepTitle">SINGLE POINT OF CONTACT-FINANCE (SPOC-FINANCE)</h4>   
      <?php
      $model=new TpdetailSpocfinance();
        // $model->validate();
        $editedBy=$model->find()->where(['edited_by' => Yii::$app->user->identity->id])->one();
        if ($editedBy) {
          $model=$model->findOne($editedBy['id']);
        }
        echo $this->render('form/form7.php', [
          'model' => $model
      ]) ?>                         
  </div>
  <div id="step-8">
      <h4 class="StepTitle">CEO/MD</h4>   
      <?php
      $model=new TpdetailCeo();
      // $model->validate();
      //    $model->validate();
        $editedBy=$model->find()->where(['edited_by' => Yii::$app->user->identity->id])->one();
        if ($editedBy) {
          $model=$model->findOne($editedBy['id']);
        }
        echo $this->render('form/form8.php', [
          'model' => $model
      ]) ?>                     
  </div> 
</div>
</div>

    </div>

</div>



<!-- <div class="modal fade bd-example-modal-lg" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Final Review</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div id="accordion">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Collapsible Group Item #1
        </button>
      </h5>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          Collapsible Group Item #2
        </button>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
      <div class="card-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
          Collapsible Group Item #3
        </button>
      </h5>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
      <div class="card-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Edit</button>
        <button type="button" class="btn btn-primary">Final Submit</button>
      </div>
    </div>
  </div>
</div> -->

<script>
jQuery(document).ready(function () {

  jQuery('#wizard').smartWizard({
    keyNavigation: false, // Enable/Disable key navigation(left and right keys are used if enabled)
    enableAllSteps: false,  // Enable/Disable all steps on first load
    transitionEffect: 'fade',
    // transitionEffect: 'slideleft',
    labelNext: 'Save & Next',
    // contentURL:'service.php',
    onLeaveStep: function (obj, context) {
      $("#erroralert").click()
      if (context.toStep < context.fromStep) {
        return true;
      }

      console.log(context);
      if (context.fromStep == 1) {
        return true;
      } else {
        context.fromStep--;
      }


      if (1) {
        if (context.fromStep > 3) {
          context.fromStep++
        }
        var data = jQuery('#tpform-' + context.fromStep).serializeArray();
        var url = jQuery('#tpform-' + context.fromStep).attr('action');
        console.log('#tpform-' + context.fromStep);
        var result;
        console.log(jQuery('#tpform-5').attr('action'));
        var temp = (jQuery.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: data,
            async: false,
          })
          .done(function (response) {
            result = (response.data.success);
            if (!result) {
              // console.log(response.data.model[Object.keys(response.data.model)][0]);
              swal({
                text: response.data.message,

                icon: "warning",
              });
            }

          })
          .fail(function () {
            result = false;
            swal({
                title: 'Network error',
                text: 'Could not connected to server',

                icon: "warning",
              });
          }));
        console.log(result);
        return result;
        // return true
      }




    },
    onShowStep: function (obj, context) {
      console.log(context);
      if (context.toStep < context.fromStep) {
        return true;
      }
      if (context.toStep>6) {
        // console.log(doIcopy);
      var doIcopy=$('#tpform-' + context.toStep).find('input.copyfromprevious')[0];
        // console.log(doIcopy.id);
        // console.log(doIcopy.value);
        if (doIcopy.checked) {
         getData( doIcopy.id, doIcopy.value)
          
        }
       

      }
    
      // jQuery('#tpform-'+context.toStep).validator()
    },
    onFinish: function (obj, context) {
      $("#erroralert").click()

      krajeeDialog.confirm("Are you really sure you want to submit your application ?", function (result) {
        if (result) { // ok button was pressed
          // context.fromStep++
          saveForm(context.fromStep)
          //  
          // execute your code for confirmation
        } else { // confirmation was cancelled
          // execute your code for cancellation

        }
      });

    }

    //     contentURLData:{
    //       'tst':1
    // }
  });

  function getData(data, targetform) {

    jQuery.ajax({
        url: 'index.php?r=tpartner/ajax-get',
        type: 'post',
        dataType: 'json',
        data: {
          'tableName': data
        }
      })
      .done(function (response) {
        for (const key in response) {
          if (response.hasOwnProperty(key)) {
            const element = response[key];

            if (key=="gender") {
            $(`select[name="${targetform}[${key}]"]`).select2('val',(element).toString())
            // $(`select[name="${targetform}[${key}]"]`).prop("disabled", true);
              // continue;
              
            }else{
              $(`input[name="${targetform}[${key}]"]`).val(element).prop("readonly", true);
            console.log($(`input[name="${targetform}[${key}]"].form-control`));
            console.log(key);
            console.log(element);
            }
          
          }
        }



      })
      .fail(function () {
        console.log("error");
      });
  }


  function saveForm(formid) {
    console.log("formid" + formid);
    var data = jQuery('#tpform-' + formid).serializeArray();
    var url = jQuery('#tpform-' + formid).attr('action');
    jQuery.ajax({
        url: url,
        type: 'post',
        dataType: 'json',
        data: data
      })
      .done(function (response) {
        console.log(response.data.success);
        if (response.data.success) {
          location.reload();
          
        }else{
          swal({
                text: response.data.message,

                icon: "warning",
              });
            
        }

      })
      .fail(function () {
        console.log("error");
      });
  }






  $('.copyfromprevious').change(function () {
    // this will contain a reference to the checkbox   
    if (this.checked) {
      if (this.name == "TpdetailCeo[copyspoc]") {
        $(`input[name="TpdetailCeo[copyspocfinance]"]`).prop("checked", false);
      } else {
        $(`input[name="TpdetailCeo[copyspoc]"]`).prop("checked", false);

      } // the checkbox is now checked 
      getData( this.id, this.value)
    } else {

      var id = (this.closest("form").id);
    
      // this.closest("form").find('input').val('').prop("readonly", false);
      jQuery('#' + id).find('input.form-control').val('').prop("readonly", false)
      jQuery('#' + id).find('select.form-control').val('').prop("disabled", false);
      // the checkbox is now no longer checked
    }
  });


 
});

 
 </script>