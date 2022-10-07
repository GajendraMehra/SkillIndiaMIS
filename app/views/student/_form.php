<?php

use yii\helpers\Url;
use aryelds\sweetalert\SweetAlert;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use app\models\EducationLevel ;
use app\models\UkDistrict ;
use app\models\Category ;
use app\models\Tcdetail ;
use app\models\Job ;
use app\models\UkBlocks ;
use app\models\SubSector ;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\States;
use app\models\Sector;
use app\models\Religion;
use app\models\CommonModel;
use yii\web\View;
use kartik\widgets\FileInput;

use app\assets\AppAsset;
use app\assets\DashboardAsset;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Student */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-form">
<small class="has-star">Aadhar card file is madatory to upload for new Registration. </small>


  <h3 class="bg-warning text-dark p-1 text-uppercase border border-primary border-3 rounded">Basic Info</h3>

  <?php $form = ActiveForm::begin([
    'id'=>'student-reg-form',
    // 'enableAjaxValidation'=>true,
    // 'enableClientValidation'=>true,
    // 'focus'=>array($model,'student_name'),
  ]); ?>
  <div class="row">
     <div class="col-md-6">
        <?= $form->field($model, 'student_name')->textInput(['maxlength' => true]) ?>

     </div>
     <div class="col-md-6">
      <?= $form->field($model, 'mother_name')->textInput(['maxlength' => true]) ?>

     </div>
  </div>
  <div class="row">
     <div class="col-md-6">
      <?= $form->field($model, 'father_name')->textInput(['maxlength' => true]) ?>

     </div>
     <div class="col-md-6">

     <?= $form->field($model, 'gender')->widget(Select2::classname(), [
                'data' =>  ['Female','Male','Other'],
                'options' => ['placeholder' => 'Select Gender...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

     </div>
  </div>
  <div class="row">
     <div class="col-md-6">
        <?= $form->field($model, 'dob')->widget(DatePicker::classname(), [
      'options' => ['placeholder' => 'Select from date ...'],
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true,
            'endDate' => "-4320d"
        ]
    ]) ?>
     </div>
     <div class="col-md-6">
     <?= $form->field($model, 'category')->textInput()->widget(Select2::classname(), [
    'data' =>   ArrayHelper::map(Category::find()->all(), 'id', 'category'),
    'options' => ['placeholder' => 'Select Category ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
    'pluginEvents' => [
        'select2:select' => 'function(e) {  }',
    ],

        ]) ?>
  </div>
  </div>

  <div class="row">

     <div class="col-md-6">
     <?= $form->field($model, 'religion')->textInput()->widget(Select2::classname(), [
    'data' =>   ArrayHelper::map(Religion::find()->orderBy(['religion_name'=>SORT_ASC])->all(), 'id', 'religion_name'),
    'options' => ['placeholder' => 'Select Religion ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
    'pluginEvents' => [
        'select2:select' => 'function(e) {  }',
    ],

        ]) ?>
  </div>

  <div class="col-md-6">
    <?= $form->field($model, 'is_disabled')->widget(Select2::classname(), [
                'data' =>  ['No','Yes'],
                'options' => ['placeholder' => 'Select Disablity Status...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Is physically disabled ?'); ?>
  </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <?= $form->field($model, 'disbality')->textArea(['rows' => 4]) ?>

    </div>
  </div>
  <h3 class="bg-warning text-dark p-1 text-uppercase border border-primary border-3 rounded" >Contact Info</h3>

  <div class="row">
      <div class="col-md-6">
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

      </div>
      <div class="col-md-6">
        <?= $form->field($model, 'phone_no')->textInput(['class' => 'numberOnly', 'onkeypress'=>'return onlyNumberKey(event)' ]) ?>

      </div>
  </div>
  <div class="row">
      <div class="col-md-6">
      <?= '<label class="control-label has-star">Select District</label>'; ?>
      <?= '<div class="form-group">'; ?>
      <?= Select2::widget( [
                      'name'=>'district-select',
                      'data' =>   ArrayHelper::map(UkDistrict::find()->orderBy(['name'=>SORT_ASC])->all(), 'id', 'name'),
                      'value'=> ($model->isNewRecord) ? "" : UkBlocks::findOne($model->block_id)->district_id,
                'options' => ['placeholder' => 'Select Sector ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'pluginEvents' => [
                    'select2:select' => 'function(e) { populateDistrictBlock(e.params.data.id); }',
                ],
            ]); ?>
       <?= '</div>' ?>
      </div>

      <div class="col-md-6">

      <?= $form->field($model, 'block_id')->textInput()->widget(Select2::classname(), [
    'data' =>   ArrayHelper::map(UkBlocks::find()->all(), 'id', 'name'),
    'options' => ['placeholder' => 'Select  Block...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
    'pluginEvents' => [
        'select2:select' => 'function(e) {  }',
    ],

]) ?>
      </div>
  </div>
  <div class="row">
      <div class="col-md-6">
        <?= $form->field($model, 'address')->textArea(['rows' => 3]) ?>

      </div>
      <div class="col-md-6">
        <?= $form->field($model, 'aadhar_no')->textInput(['onkeypress'=>'return onlyNumberKey(event)']) ?>
        <?= $form->field($model, 'pin_code')->textInput(['onkeypress'=>'return onlyNumberKey(event)']) ?>

      </div>
  </div>
  <h3 class="bg-warning text-dark p-1 text-uppercase border border-primary border-3 rounded" >Other Info</h3>
  <div class="row">
  <div class="col-md-6">
  <?= $form->field($model, 'sip_id')->textInput([]) ?>

  </div>
  <div class="col-md-6">
  <?= $form->field($model, 'employment_id')->textInput([]) ?>

  </div>
  </div>

  <div class="row">
      <div class="col-md-6">
      <?= $form->field($model, 'hope_id')->textInput(['class' => 'numberOnly']) ?>

      </div>
      <div class="col-md-6">
      <?= $form->field($model, 'max_edu')->textInput()->widget(Select2::classname(), [
    'data' =>   ArrayHelper::map(EducationLevel::find()->all(), 'id', 'education'),
    'options' => ['placeholder' => 'Select Education Level ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
    'pluginEvents' => [
        'select2:select' => 'function(e) {  }',
    ],

]) ?>

      </div>
  </div>
<?php

if ($model->isNewRecord) {

?>
  <div class="row">
      <div class="col-md-6">

      <?= $form->field($model, 'prefrence_district')->textInput()->widget(Select2::classname(), [
    'data' =>   ArrayHelper::map(UkDistrict::find()->orderBy(['name'=>SORT_ASC])->all(), 'id', 'name'),
          'options' => ['placeholder' => 'Select District ...'],
          'pluginOptions' => [
              'allowClear' => true
          ],
          'pluginEvents' => [
            'select2:select' => 'function(e) { populateSectors(e.params.data.id); }',

          ],

      ]) ?>

      </div>
      <div class="col-md-6">

      <?= '<label class="control-label has-star">Select Sector</label>'; ?>
<?= '<div class="form-group">'; ?>
<?= Select2::widget( [
                'name'=>'sector-select',
                'data' =>  ($model->isNewRecord) ? "" : ArrayHelper::map(Sector::find()->all(), 'id', 'sector_name'),
                'value'=> ($model->isNewRecord) ? "" : SubSector::findOne(['nsdc_sub_sector_id'=>Job::findOne($model->prefrence_job)->sub_sector_id])->sector_id,

                'options' => ['placeholder' => 'Select Sector ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'pluginEvents' => [
                    'select2:select' => 'function(e) { populateSectorJobs(e.params.data.id); }',
                ],
            ]); ?>
       <?= '</div>' ?>


      </div>
  </div>



  <div class="row">
      <div class="col-md-6">
      <?= $form->field($model, 'prefrence_job')->textInput()->widget(Select2::classname(), [
        //   'data' =>   ArrayHelper::map(Job::find()->all(), 'id', 'job_name'),
          'options' => ['placeholder' => 'Select Job ...'],
          'pluginOptions' => [
              'allowClear' => true
          ],
          'pluginEvents' => [
              'select2:select' => 'function(e) {  }',
          ],

      ]) ?>
      </div>
      <div class="col-md-6">

      </div>
  </div>

  <?php

}else{ ?>
  <div class="row">
      <div class="col-md-6">
      <?= $form->field($model, 'prefrence_job')->textInput()->widget(Select2::classname(), [
          'data' =>   ArrayHelper::map(Job::find()->all(), 'id', 'job_name'),
          'options' => ['placeholder' => 'Select Job ...'],
          'pluginOptions' => [
              'allowClear' => true
          ],
          'pluginEvents' => [
              'select2:select' => 'function(e) {  }',
          ],

      ]) ?>
      </div>
      <div class="col-md-6">

      </div>
  </div>
<?php }
?>

<div class="row">
  <div class="col-md-12">
  <?php

echo $form->field($model, 'adhar_file')->widget(FileInput::classname(), [
  'name'=>'adhar_file',
  'options' => ['accept' => ['image/*','/pdf','required'=>'required']],
   'pluginOptions'=>[
       
    'allowedFileExtensions'=>['jpg','jpeg','png','pdf'],'showUpload' => false,

   'showCaption' => false,
   'showRemove' => true,
   'showUpload' => false,
   'showCancel' => false,
   'browseClass' => 'btn btn-primary btn-sm',
  //  'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
   'browseLabel' =>  'Choose File',
   'maxFileSize'=>300
  ],
])->label("Aadhar Card Scanned File");

?>
</div>
</div>
<div class="form-group text-center">
<?= ($model->isNewRecord) ? $form->field($model, "i_agree")->checkbox(['value' => "1",])->label("I agree the terms and conditions"):"" ?>
<?= ($model->isNewRecord) ? Html::button('Add Student ', ['onclick'=>'triggerSmsMain()','class' => 'btn btn-success']) : Html::submitButton('Update Student ', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>


<!-- modal -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
        <h5 class="modal-title" id="exampleModalLabel">Verify Mobile No.</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <p>Please fill 6 digit OTP received on your no. <span id="phoneNoText"></span> </p>
   
   <?php $form = ActiveForm::begin([
       'id'=>'changepassword-form',
       'options'=>['class'=>'form-vertical'],
       
   ]); ?>
     <div class="form-group highlight-addon field-student-phone_no required">
<label class="has-star" for="student-phone_no">OTP </label>

<input type="text" id="student-otp" placeholder="Enter 6 digit OTP"  class="numberOnly form-control" name="Student[otp]" value="" onkeypress="return onlyNumberKey(event)" aria-required="true">

<p class="text-center">If not received <a onClick="triggerSms()" class="text-primary" href="#">Click Here </a></p>

</div>
      <div class="text-center">
        <button onClick="verifyOTP()" type="button" class="btn btn-success" data-dismiss="">Verify</button>
      
   <?php ActiveForm::end(); ?>
      </div>
    </div>
  </div>
</div>



<script>


var magicNo=Math.floor(100000 + Math.random() * 900000).toString();
var url=''
var timestamp='';
function getTimestampInSeconds () {
  return Math.floor(Date.now() / 1000)
}
function triggerSmsMain(){
  $('#student-reg-form :input').blur()
  setTimeout(() => {
    triggerSms()
}, 1000);
}
function verifyOTP(){
  const inputOPT=$("#student-otp").val()
  const currentTimeStamp=getTimestampInSeconds()
  if(currentTimeStamp-timestamp>60*60*10&&inputOPT.length===6){
    toastr.error("Time out. Please try with new OTP.")
    return false
  }
  if(inputOPT.length!==6){
    toastr.error("Invalid OTP. Please enter 6 digit OTP.")
    return false
  }

  // if(timesta)
  if(inputOPT===magicNo){
    toastr.success("Mobile No Verified.")
    setTimeout(() => {
      $('#student-reg-form').submit()
    }, 1000);
  }
  else{
    toastr.error("Invalid OTP.")

  }
  return false
}

function sendSMS(){
  timestamp=getTimestampInSeconds()
  $.ajax({
    url: url,
    success: function (data) {
     console.log(data)
     $('#exampleModal').modal('show')
      toastr.success("OTP sent .")

    },
    error:function(){
      $('#exampleModal').modal('show')
      toastr.success("OTP sent .")

    }

});
}
 function  triggerSms(){
  const stuForm=$('#student-reg-form');

  stuForm.click()
  const file =$('#student-adhar_file').val()
console.log(file)

  if(stuForm.find('.has-error').length){
    toastr.error('Please fill all the fields correctly')
    return false
  }
  if(file.length===0){
    toastr.error('Please upload file upto 300kb')
    return false
  }
  $('#phoneNoText').text($('#student-phone_no').val())
const hostName="http://164.52.195.161/API/SendMsg.aspx?send=UKSDMS&priority=1";
const uname="&uname="+20220402;
const pass="&pass="+"D9prm9H2";
const dest="&dest="+$('#student-phone_no').val();
const currentTimeStamp=getTimestampInSeconds()
 magicNo=Math.floor(100000 + Math.random() * 900000).toString();

// if(currentTimeStamp-timestamp>60*60*10){
//  magicNo=Math.floor(100000 + Math.random() * 900000).toString();
// }

  // const url="http://164.52.195.161/API/SendMsg.aspx?uname=20220402&pass=D9prm9H2&send=UKSDMS&dest=8755515001&"
const text=`Dear User,

OTP for Login Verification on UKSDM Portal is ${magicNo}.

Only valid till 10 minutes.`;
 const msg="&msg="+encodeURIComponent(text);

  url=hostName+uname+pass+dest+msg;
  $('#exampleModal').modal('show')
  sendSMS()
//  alert(url)

  //$('#student-reg-form').submit()
}
function populateSectorJobs(district_id) {

var url = '<?= Url::to(['site/populate-sector-jobs', 'id' => '-id-']) ?>';
var $select = $('#student-prefrence_job');
$select.find('option').remove().end();
$.ajax({
    url: url.replace('-id-', district_id),
    success: function (data) {
      var select2Options={
        placeholder: "Select Job",
       width: "100%"
  }
        select2Options.data = data.data;
        $select.select2(select2Options);
        $select.val(data.selected).trigger('change');
    }
});
}


function populateDistrictBlock(district_id) {

var url = '<?= Url::to(['site/populate-district-block', 'id' => '-id-']) ?>';
var $select = $('#student-block_id');
$select.find('option').remove().end();
$.ajax({
    url: url.replace('-id-', district_id),
    success: function (data) {
      var select2Options={
        placeholder: "Select Block",
       width: "100%"
  }
        select2Options.data = data.data;
        $select.select2(select2Options);
        $select.val(data.selected).trigger('change');
    }
});
}



function populateSectors() {
  $('#student-prefrence_job').val('').trigger('change');
  $('#sector-select').val('').trigger('change');
  $('#student-prefrence_job').val('').trigger('change');
  var $select1 =  $('#student-prefrence_job')
  $select1.find('option').remove().end()
  $select1.select2({
    data:null,
    placeholder: "Select Sector",
       width: "100%"
  })
  $select1.trigger('change');
  var tcid = <?= @Tcdetail::find()->where(['email' => Yii::$app->user->identity->email])->one()['id']; ?>;
  console.log(tcid);
  var did= $('#student-prefrence_district').val();
var url = '<?= Url::to(['site/populate-tc-sectors', 'id' => '-id-','did' => '-did-']) ?>';
var $select = $('select[name=sector-select]');
$select.find('option').remove().end();
$.ajax({
    url: url.replace('-id-', tcid),
    url: url.replace('-did-', did),
    success: function (data) {
      console.log(data);
      if (data.data.length==1) {
        swal("Selected District has No Jobs")
      }
      var select2Options={
        placeholder: "Select Sector",
       width: "100%"
        }
        select2Options.data = data.data;
        $select.select2(select2Options);
        $select.val(data.selected).trigger('change');
    }
});
}


 

</script>
