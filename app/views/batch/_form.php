<?php
use yii\helpers\Url;

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\BatchTrainingType;
use app\models\Job as Jobs;
use app\models\TargetsResponse;
use app\models\CommonModel;
use kartik\widgets\TimePicker;
/* @var $this yii\web\View */
/* @var $model app\models\TargetBatch */
/* @var $form yii\widgets\ActiveForm */

function getTargets($tc)
{
    $tr=TargetsResponse::find()->select('tbl_targets_response.id,tbl_targets_response.target_id,')
    ->innerJoin('tbl_targets', 'tbl_targets.id = tbl_targets_response.target_id')
    ->asArray()->where(['tc_id'=> $tc,'tbl_targets_response.status'=>1,'tbl_targets.status'=>1])->all();
  $data=[];
    foreach ($tr as $key => $value) {
      $data[$key]['id']=$value['id'];
      $data[$key]['target_id']=Yii::$app->params['target_prefix'].$value['target_id'].'/'.$value['id'];
    }
    return $data;
}
?>

<div class="target-batch-form col-md-10">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
      <div class="col-md-6 col-sm-12">
        <?= $form->field($model, 'batch_name')->textInput(['maxlength' => true]) ?>

      </div>
      <div class="col-md-6 col-sm-12">
        <?= $form->field($model, 'training_type')->textInput()->widget(Select2::classname(), [
       'data' =>   ArrayHelper::map(BatchTrainingType::find()->all(), 'id', 'type_name'),
       'options' => ['placeholder' => 'Select  Training Type...'],
       'pluginOptions' => [
           'allowClear' => true
       ],
      

           ]) ?>

      </div>
  </div>


  <div class="row">
      <div class="col-md-6 col-sm-12">
      <?= $form->field($model, 'sub_target_id')->textInput()->widget(Select2::classname(), [
                     'data' =>   ArrayHelper::map(getTargets($model->tc_id), 'id', 'target_id'),
                     'options' => ['placeholder' => 'Select Target ID for Batch ...'],
                      'pluginOptions' => [
                      'allowClear' => true,
                      
                      ],
                      'pluginEvents' => [
                        'select2:select' => 'function(e) { populateTargetsJobs(e.params.data.id); }',

                      ],
                   
                ])->label("Select Active Target ID for Batch"); ?>
        

      </div>
      <div class="col-md-6 col-sm-12">
      <?= $form->field($model, 'job_id')->textInput()->widget(Select2::classname(), [
                    'data' =>   ArrayHelper::map(Jobs::find()->all(), 'id', 'job_name'),
                    'options' => ['placeholder' => 'Target Job'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                   
                   
                ]); ?>
      </div>
  </div>
  <div class="row">
      <div class="col-md-6 col-sm-12">
        <?= $form->field($model, 'min_size')->textInput(['maxlength'=>7,'class' => 'numberOnly', 'onkeypress'=>'return onlyNumberKey(event)' ]) ?>

      </div>
      <div class="col-md-6 col-sm-12">
        <?= $form->field($model, 'max_size')->textInput(['class' => 'numberOnly','maxlength'=>7, 'onkeypress'=>'return onlyNumberKey(event)' ]) ?>

      </div>
  </div>
  <div class="row">
      <div class="col-md-6 col-sm-12">
        <?= $form->field($model, 'start_date')->widget(DatePicker::classname(), [
      'options' => ['placeholder' => 'Select Batch Start Date ...'],
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true,
        
        ]
    ]) ?>

      </div>
      <div class="col-md-6 col-sm-12">
        <?= $form->field($model, 'end_date')->widget(DatePicker::classname(), [
      'options' => ['placeholder' => 'Select Batch End Date ...'],
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true,
           
        ]
    ]) ?> 

      </div>
  </div>
  <div class="row">
      <div class="col-md-6 col-sm-12">
        <?= $form->field($model, 'start_time')->widget(TimePicker::classname(), [

          'pluginOptions' => [
              'showSeconds' => false,
              'showMeridian' => true,
              'minuteStep' => 10,
              ]

        ]); ?>

      </div>
      <div class="col-md-6 col-sm-12">
        <?= $form->field($model, 'end_time')->widget(TimePicker::classname(), [
          'pluginOptions' => [
              'showSeconds' => false,
              'showMeridian' => true,
              'minuteStep' => 10,
              ]

        ]); ?>

      </div>
  </div>
  <div class="row">
      <div class="col-md-6 col-sm-12">
        <?= $form->field($model, 'trainer_name')->textInput(['maxlength' => true]) ?>

      </div>
      <div class="col-md-6 col-sm-12">
        <?= $form->field($model, 'assesment_date')->widget(DatePicker::classname(), [
      'options' => ['placeholder' => 'Select Assesment Date ...'],
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true,
            'startDate' => "+0d"
        ]
    ]) ?>
      </div>
  </div>
  <div class="row">
  <div class="col-md-6 col-sm-12">

  <?= $form->field($model, 'sip_id')->textInput([]) ?>
  
  </div>

  <div class="col-md-6 col-sm-12">

  <?php 
  if (Yii::$app->user->identity->role==1) {
    echo $form->field($model, 'final_submit')->textInput()->widget(Select2::classname(), [
      'data' =>  ["Not Submitted","Submited"],
      'options' => ['placeholder' => 'Select Status'],
      'pluginOptions' => [
          'allowClear' => true
      ],
    ]);
}

?>

</div>
  </div>












    <div class="form-group text-right">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<script type="text/javascript">

function populateTargetsJobs(id) {

var url = '<?= Url::to(['targetresponse/populate-targets-jobs', 'id' => '-id-']) ?>';
var $select = $('#targetbatch-job_id');
$select.find('option').remove().end();
$.ajax({
    url: url.replace('-id-', id),
    success: function (data) {
      console.log(data);
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

</script>
