<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Rate;
use yii\helpers\Url;

$this->title = "Proceed to Finance Department";
$this->params['breadcrumbs'][] = ['label' => 'Tranche Details', 'url' => ['view','id'=>$model->id]];
$this->params['breadcrumbs'][] = $this->title;
$claim=$model->claim_type+1;
?>


<div class="card card-primary border-info">
    <div class="card-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
    <h5><?= $this->title ?></h5>
    </div>
    <div class="card-body">
 
        

        <?php 
      echo $this->render('_prev_details', ['model' => $model]);

$form = ActiveForm::begin(
    [
        'method'=>'POST',
        'action' => 'index.php?r=trans/forward&id='.$model->id ,
        'options' => [
            'class' => 'userform'
            ]
            ]
            
        ); 
        echo $this->render('decelaration/trans'.$model->claim_type);
      
        echo $form->field($model, 'status')->hiddenInput(['value'=> 1])->label(false);  ?>
        <div class="row">
        <div class="col-md-4">
            <?= '<label class="control-label has-star">Select Rate</label>'; ?>
            <?= '<div class="form-group">'; ?>
            <?= Select2::widget( [
                        'name'=>'rate-select',
                        'data' =>   ArrayHelper::map(Rate::find()->orderBy(['rate_name'=>SORT_ASC])->all(), 'id', 'rate_name'),
                        'options' => ['placeholder' => 'Select Rate ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        'pluginEvents' => [
                            'select2:select' => 'function(e) { populateRateInfo(e.params.data.id); }',
                        ],
                    ]); ?>
            <?= '</div>' ?>
        </div>
        

 
        <div class="col-md-4">
        <?= $form->field($model, 'rate_info_id')->textInput()->widget(Select2::classname(), [
        //   'data' =>   ArrayHelper::map(Job::find()->all(), 'id', 'job_name'),
          'options' => ['placeholder' => 'Select Amount ...','required'=>true],
          'pluginOptions' => [
              'allowClear' => true
          ],
          'pluginEvents' => [
              'select2:select' => 'function(e) {  }',
          ],

      ])->label("Select Amount")


 ?>
        
        </div>


        <div class="col-md-4">
        <?= $form->field($model, 'trans_percent')->textInput(['value'=>Yii::$app->config->get('trans_'.$claim,'40')])->label("Trans Percentage"); ?>
        
        </div>
        </div>
         
        <div class="form-group text-center">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>


<script>
function populateRateInfo(rate_id) {

var url = '<?= Url::to(['rate/populate-rate-amount', 'rid' => '-id-']) ?>';
var $select = $('select[name="TransDetail[rate_info_id]"]');
$select.find('option').remove().end();
$.ajax({
    url: url.replace('-id-', rate_id),
    success: function (data) {
      console.log(data);
      var select2Options={
        placeholder: "Select Amount",
       width: "100%"
  }
        select2Options.data = data.data;
        $select.select2(select2Options);
        $select.val(data.selected).trigger('change');
    }
});
}

$(".userform").on("submit", function(e){
   
    e.preventDefault();
  swal("Are you confirm you want to proceed this Tranche to finance Department. Please Verify Decelartion and Rate Value .?", {
    buttons: {
      yes: {
        text: "Yes",
        value: "yes"
      },
      no: {
        text: "No",
        value: "no"
      }
    }
  }).then((value) => {
    if (value === "yes") {
        this.submit();
    }
    return false;
  });

 });
//    return false;
</script>