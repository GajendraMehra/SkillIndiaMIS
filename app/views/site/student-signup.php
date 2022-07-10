<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Url;
use aryelds\sweetalert\SweetAlert;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use app\models\EducationLevel ;
use app\models\UkDistrict ;
use app\models\Category ;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\States;
use app\models\Sector;
use app\models\Religion;
use yii\web\View;
use kartik\widgets\FileInput;
use app\assets\AppAsset;
use app\assets\DashboardAsset;
use kartik\date\DatePicker;



DashboardAsset::register($this);

?>
<style>
body{
  background-image: url('custom/images/studentbg.png');
            /* Background image is centered vertically and horizontally at all times */
  background-position: center center;

  /* Background image doesn't tile */
  background-repeat: no-repeat;

  /* Background image is fixed in the viewport so that it doesn't move when
     the content's height is greater than the image's height */
  background-attachment: fixed;

  /* This is what makes the background image rescale based
     on the container's size */
  background-size: cover;

  /* Set a background color that will be displayed
     while the background image is loading */
  background-color: #464646;
}

#student-wrapper{
  /* background-color;"#123abc" */
  opacity:0.95;
  margin-top:1em;
}

</style>
<!-- <nav class="navbar navbar-expand-md navbar-dark bg-primary">
  <a class="navbar-brand" href="#">
  <img  src='custom/images/logo1.png' height="100px" alt="" srcset="">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">



    </ul>
    <div class="form-inline my-2 my-lg-0">
    <!-- <h3>Student Registration Portal</h3> -->
      <!-- <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-info my-2 my-sm-0" type="submit">
      Back</button>
    </form>
  </div>
</nav> -->
<div class="row">
  <div class="col-8 col-lg-8 col-md-11 col-sm-12 col-offset-3" style="margin:auto">
    <div class="card card-primary ml-3 border-info" id="student-wrapper">
      <div class="card-header text-white bg-primary">
        <h5 class="text-uppercase">Student Registration Portal </h5>
      </div>
      <div class="card-body">
      <div class="text-center">
      <img
        src='custom/images/logo1.png'
        width="100px" height="100px" class="rounded mb-2" alt="This is logo image " srcset="">
        <!-- <img
        src='custom/images/studentlogo.png'
        width="100px" height="100px" class="rounded mb-2" alt="This is logo image " srcset=""> -->


    </div>
      <div class="student-form">

      <h3 class="bg-warning text-dark p-1 text-uppercase border border-primary border-3 rounded">Basic Info</h3>
<small class="has-star">Aadhar card file is madatory to upload</small>

      <?php $form = ActiveForm::begin(); ?>
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
        'data' =>   ArrayHelper::map(Religion::find()->all(), 'id', 'religion_name'),
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
                ])->label('Are you physically disable ?'); ?>
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
          <?= '<label class="control-label has-star">Select district</label>'; ?>
          <?= '<div class="form-group">'; ?>
          <?= Select2::widget( [
                          'name'=>'district-select',
                          'data' =>   ArrayHelper::map(UkDistrict::find()->orderBy(['name'=>SORT_ASC])->all(), 'id', 'name'),
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
        // 'data' =>   ArrayHelper::map(EducationLevel::find()->all(), 'id', 'education'),
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
      <div class="row">
          <div class="col-md-6">
            <?= $form->field($model, 'address')->textArea(['rows' => 4]) ?>

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
       'data' =>   ArrayHelper::map(EducationLevel::find()->orderBy([ 'education'=>SORT_ASC ])->all(), 'id', 'education'),
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

      <div class="row">
          <div class="col-md-6">

          <?= $form->field($model, 'prefrence_district')->textInput()->widget(Select2::classname(), [
        'data' =>   ArrayHelper::map(UkDistrict::find()->orderBy(['name'=>SORT_ASC])->all(), 'id', 'name'),
              'options' => ['placeholder' => 'Select District ...'],
              'pluginOptions' => [
                  'allowClear' => true
              ],
              'pluginEvents' => [
                'select2:select' => 'function(e) { populateCenters(e.params.data.id); }',

              ],

          ]) ?>

          </div>
          <div class="col-md-6">
            <?= $form->field($model, 'selected_tc')->textInput()->widget(Select2::classname(), [

                'options' => ['placeholder' => 'Select Training Center  ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'pluginEvents' => [
                  'select2:select' => 'function(e) { populateSectors(e.params.data.id); }',

                ],

            ]) ?>



          </div>
      </div>



      <div class="row">
          <div class="col-md-6">

            <?= '<label class="control-label has-star">Select Sector</label>'; ?>
      <?= '<div class="form-group">'; ?>
      <?= Select2::widget( [
                      'name'=>'sector-select',
                      'id'=>'sector-select',
                      // 'data' =>   ArrayHelper::map(Sector::find()->all(), 'id', 'sector_name'),
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
          <div class="col-md-6">
            <?= $form->field($model, 'prefrence_job')->textInput()->widget(Select2::classname(), [
          // 'data' =>   ArrayHelper::map(EducationLevel::find()->all(), 'id', 'education'),
          'options' => ['placeholder' => 'Select Job ...'],
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
  <div class="col-md-12">
  <?php

echo $form->field($model, 'adhar_file')->widget(FileInput::classname(), [
  'name'=>'adhar_file',
  'options' => ['accept' => ['image/*','/pdf','required'=>true]],
   'pluginOptions'=>[
       
      'allowedFileExtensions'=>['jpg','jpeg','png','pdf'],'showUpload' => false,

   'showCaption' => false,
   'showRemove' => true,
   'showUpload' => false,
   'showCancel' => false,
   'browseClass' => 'btn btn-primary btn-sm',
   'maxFileSize'=>300,
   'browseLabel' =>  'Choose File'
  ],
])->label("Aadhar Card Scanned File");

?>
</div>
</div>


<div class="form-group text-center">
<?= $form->field($model, "i_agree")->checkbox(['value' => "1",])->label("I agree the terms and conditions"); ?>

    <?= Html::submitButton('Register Me', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>



        </div>

      </div>
    </div>
  </div>

</div>




<script>


function populateSectorJobs(district_id) {
  $('#student-prefrence_job').val('').trigger('change');

var url = '<?= Url::to(['site/populate-tc-sector-jobs', 'id' => '-id-']) ?>';
var $select = $('#student-prefrence_job');
$select.find('option').remove().end();
$.ajax({
    url: url.replace('-id-', district_id),
    data:{
      centerId:$('#student-selected_tc').val()
    },
    success: function (data) {
      var select2Options={
        placeholder: "Select Job",
       width: "100%",
       allowClear: true
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


function populateSectors(center_id) {
  $('#student-prefrence_job').val('').trigger('change');
  $('#sector-select').val('').trigger('change');

var url = '<?= Url::to(['site/populate-tc-sectors', 'id' => '-id-','did' => '-did-']) ?>';
var did= $('#student-prefrence_district').val();
var $select = $('#sector-select');
url=url.replace('-id-', center_id);
$select.find('option').remove().end();
$.ajax({

    url: url.replace('-did-', did),
    success: function (data) {
      console.log(data);
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
function populateCenters(district_id) {
  var $select1 =  $('#sector-select');
  $select1.find('option').remove().end()
  $select1.select2({
    data:null,
    placeholder: "Select Sector",
       width: "100%"
  })
  $select1.trigger('change');
  $('#student-prefrence_job').val('').trigger('change');

var url = '<?= Url::to(['site/populate-centers', 'id' => '-id-']) ?>';
var $select = $('#student-selected_tc');
$select.find('option').remove().end();
$.ajax({
    url: url.replace('-id-', district_id),
    success: function (data) {
      if (data.data.length==0) {
        swal("Selected District has no active Training Center")
      }
      var select2Options={
        placeholder: "Select Training Centers",
       width: "100%"
  }
        select2Options.data = data.data;
        $select.select2(select2Options);
        $select.val(data.selected).trigger('change');
    }
});
}
// A $( document ).ready() block.
$( document ).ready(function() {

// swal('dfs')
swal("Before you Register ! Make sure you have your valid HOPE ID ,SIP ID and Emploment ID.", {
buttons: {
cancel: "I Have",
catch: {
text: "I don't have!",
text: "I don't have!",
value: "catch",
},

},
})
.then((value) => {
switch (value) {



case "catch":
// swal("");
var win = window.open('https://hope.uk.gov.in/UKCitizen.aspx', '_blank');
win.focus();
break;

default:

}
});


console.log( "ready!" );

});


</script>
