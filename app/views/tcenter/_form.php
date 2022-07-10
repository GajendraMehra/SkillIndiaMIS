<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use app\models\States;
use app\models\Cities;
use app\models\UkDistrict;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Tcdetail */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="card border-info">
    <div class="card-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
        <div class="float-right">
            <!-- <div class="summary">Showing <b>1-3</b> of <b>3</b> items.</div> -->
        </div>
        <h5 class="m-0"></h5>
        <h5>CREATE NEW</h5>
        <div class="clearfix"></div>
    </div>
    <div class="kv-panel-before">
      
        <div class="clearfix"></div>
    </div>
    
    <div id="w0-container" class="table-responsive kv-grid-container">
    <div class="tcdetail-form m-4">


<?php $form = ActiveForm::begin([
    //   'id'=>'sales-form',
    //   'enableAjaxValidation' => true,
      'enableClientValidation' => true,
]); 


?>

<h4 class="badge badge-success mb-2">BASIC DETAILS </h4>
<div class="row">
    <div class="col-md-4">
        <?= $form->field($model, 'name')->textInput() ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'smart_tcid')->textInput([ 'class' => 'text-uppercase'])?>
    </div>
    <div class="col-md-4">
    <?= $form->field($model, 'email')->textInput(['onkeyup'=>"checkemail(this)",
     'readonly' =>!$model->isNewRecord,
    ])->label("Center Email")->hint("Please fill this email carefully. Account Activation Mail will be sent on this Email Id after admin Target Approval. ")?>
        
    </div>
</div>

<div class="row">
    <div class="col-md-6">
    <?= $form->field($model, 'is_pmkk')->textInput()->widget(Select2::classname(), [
                    'data' =>  ['No','Yes'],
                    'options' => ['placeholder' => 'Select PMKK Status...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('Pradhan Mantri Kaushal Kendra (PMKK)');?>

    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'tcenter_type')->textInput()->widget(Select2::classname(), [
                    'data' =>  ['Mobile','Permanent'],
                    'options' => ['placeholder' => 'Select Center type...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'is_hostel')->textInput()->widget(Select2::classname(), [
                    'data' =>  ['No','Yes'],
                    'options' => ['placeholder' => 'Hostel Avaliable...', ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'hostel_capacity')->textInput(['class' => 'numberOnly', 'onkeypress'=>'return onlyNumberKey(event)' ])  ?>
    </div>
</div>

<h4 class="badge badge-success mb-2">ADDRESS DETAILS </h4>

<div class="row">
    <div class="col-md-4">
        <?= $form->field($model1, 'address_line') ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model1, 'post_office') ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model1, 'pin_code')->textInput(['class' => 'numberOnly', 'onkeypress'=>'return onlyNumberKey(event)' ])  ?>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
    <?= $form->field($model1, 'state_id')->widget(Select2::classname(), [
                    'data' =>   ArrayHelper::map(States::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => 'Uttrakhand','disabled'=>false,'value' => 33],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                    'value'=>85,
                    'pluginEvents' => [
                        'select2:select' => 'function(e) { populateCityName(e.params.data.id); }',
                    ],
                ]); ?>
    </div>
    <div class="col-md-4">
    <?= $form->field($model1, 'city_id')->widget(Select2::className(), [
            'model' => $model1,
            'attribute' => 'city_id',
            'data' => ArrayHelper::map(UkDistrict::find()->orderBy([
                'name' => SORT_ASC
                ])->all(), 'id', 'name'),
            'options' => [
                'placeholder' => 'Select City',
                'width' => '100%',
            ]
        ]); ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model1, 'village') ?>
    </div>
</div>

 <h4 class="badge badge-success mb-2">BANK DETAILS  </h4>

<div class="row">
    <div class="col-md-4">
    <?= $form->field($model2, 'account_number')->textInput(['class' => 'numberOnly', 'onkeypress'=>'return onlyNumberKey(event)' ])  ?>

    </div>
    <div class="col-md-4">
    <?= $form->field($model2, 'account_name') ?>
    </div>
    <div class="col-md-4">
    <?= $form->field($model2, 'bank_name') ?>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
    <?= $form->field($model2, 'ifsc_code')->textInput([ 'class' => 'text-uppercase'])?>
    </div>

</div>

<h4 class="badge badge-success mb-2">SPOC OPERATION DETAILS</h4>

<div class="row">
    <div class="col-md-4">
    <?= $form->field($model3, 'name') ?>


    </div>
    <div class="col-md-4">
    <?= $form->field($model3, 'gender')->widget(Select2::classname(), [
                    'data' =>  ['Female','Male','Other'],
                    'options' => ['placeholder' => 'Select Gender...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
    </div>
    <div class="col-md-4">
    <?= $form->field($model3, 'designation') ?>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
    <?= $form->field($model3, 'aadhar_no')->textInput(['class' => 'numberOnly', 'onkeypress'=>'return onlyNumberKey(event)' ])  ?>
    </div>
  <div class="col-md-4">
  <?= $form->field($model3, 'mobile_no')->textInput(['class' => 'numberOnly', 'onkeypress'=>'return onlyNumberKey(event)' ])  ?>
    </div>
  <div class="col-md-4">
  <?= $form->field($model3, 'email') ?>
    </div>

</div> 
    

<div class="form-group text-right col-md-12">
        <?php $btnName=($model->isNewRecord)?"Create":"Update" ?>
        <?= Html::a('Cancel', ['/tcenter/index'], ['class'=>'btn btn-info grid-button']) ?>
        <?= Html::submitButton(Yii::t('app', $btnName), ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>

</div>

<!-- tcenter-form1 -->


    </div>
    
    <div class="card-footer">
       
    </div>
</div>
<?php ob_start(); ?>
        <script>

            function checkemail(params) {
                $.ajax({
            url:'index.php?r=tcenter/check-email',
            method:"POST",
            data:{
                email:params.value
            },
            success: function (data) {
             if (data) {
                toastr.error(`Email : ${params.value} is already registered with us.`)
                 params.value=""
             }
            }
        });
            }

            $("#tcdetail-email").on("input", function(){
                checkemail(this)
                $("#tcdetail-email").text($(this).val());
            });
            function populateCityName(state_id) {
        var select2Options={
            placeholder: "Select City",
            width: "100%"
        }
        var url = '<?= Url::to(['tpartner/populate-city-name', 'id' => '-id-']) ?>';
        var $select = $('#tcenteraddress-city_id');
        $select.find('option').remove().end();
        $.ajax({
            url: url.replace('-id-', state_id),
            success: function (data) {
                console.log(data);
               
              
                select2Options.data = data.data;
                console.log($select);
                $select.select2(select2Options);
                $select.val(data.selected).trigger('change');
            }
        });
    }
    
        </script>
    <?php $this->registerJs(str_replace(['<script>', '</script>'], '', ob_get_clean()), View::POS_END); ?>

