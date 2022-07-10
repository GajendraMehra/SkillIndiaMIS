<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;

$this->title = "Send Data to Skill India";
$this->params['breadcrumbs'][] = ['label' => 'Target Batches', 'url' => ['index','type'=>3]];
$this->params['breadcrumbs'][] = ['label' => $model->batch_name, 'url' => ['view','id'=>$model->id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<textarea style="width:100%;height:650px;font-family:ubuntu" id="myTextArea" readonly><?= $data?></textarea>
<?php if ($model->final_submit==-1): ?>
  <div class="alert alert-success text-center" role="alert">
  Data Sent for assesment.
  </div>
<?php else: ?>
  <?php $form = ActiveForm::begin(); ?>
  <div class="form-group text-center">
    <input type="checkbox" name="option[]" id="option-1" value="option1" required/> I have Checked and Verified all Information
  </div>
  <div class="form-group text-center">

      <?= Html::submitButton('Send Data', ['class' => 'btn btn-success',]) ?>
  </div>
  <?php ActiveForm::end(); ?>
<?php endif; ?>


<script type="text/javascript">
$.fn.json_beautify= function() {
   var obj = JSON.parse( this.val() );
   var pretty = JSON.stringify(obj, undefined, 4);
   this.val(pretty);
};

// Then use it like this on any textarea
$('#myTextArea').json_beautify();
</script>
