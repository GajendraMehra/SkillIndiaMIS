<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use app\models\Scheme;
use app\models\Job;
use app\models\TpartnerDetail;
use app\models\SchemeJobs;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Targets */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="targets-form col-md-8">

    <?php $form = ActiveForm::begin(); ?>

    
        <?= $form->field($model, 'tp_id')->textInput()->widget(Select2::classname(), [
        'data' =>   ArrayHelper::map(TpartnerDetail::find()->all(), 'id', 'tp_name'),
        'options' => ['placeholder' => 'Select Training Partner...'],
        'pluginOptions' => [
            'allowClear' => true,
            'disabled' => true
        ],
    ]) ?>
     


     
<?= $form->field($model, 'number')->textInput() ?>
   <!-- <h4 class="badge badge-success mb-2">Job Wise Targets </h4> -->



    <div class="form-group text-right">
    <?= Html::a('Cancel', ['/target/index'], ['class'=>'btn btn-info grid-button']) ?>

        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn grid-button btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>

function populateJobName(scheme_id) {
    var url = '<?= Url::to(['job/populate-job-name', 'id' => '-id-']) ?>';

    $.ajax({
            url: url.replace('-id-', scheme_id),
            success: function (data) {
                console.log(data.data);
        var dynamic='';
             data.data.forEach(element => {
                 dynamic+=` <tr>
      <th scope="row">JOB/0${element.job_id}</th>
      <td>${element.schemejobs.job_name}</td>
      <td>${element.schemejobs.qp_code}</td>
      <td>${element.schemejobs.net_hours}</td>
      <td><input type="number" name="Targets[jobs][${element.job_id}]" onkeypress='return onlyNumberKey(event)' onkeyup="" min="1" max="10000" id=""></td>
    </tr>`;
             });
             $('#jobrows').html(dynamic)
            }
        });
}
// test()


</script>