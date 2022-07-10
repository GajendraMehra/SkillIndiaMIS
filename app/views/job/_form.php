<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

use kartik\select2\Select2;
use app\models\SubSector;
// use app\models\TpartnerDetail;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\Job */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="job-form col-md-10">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'job_name')->textinput() ?>

        </div>
        <div class="col-md-6">
             <?= $form->field($model, 'sub_sector_id')->textInput()->widget(Select2::classname(), [
                    'data' =>   ArrayHelper::map(SubSector::find()->all(), 'nsdc_sub_sector_id', 'sub_sector_name'),
                    'maintainOrder' => true,
                    'options' => ['placeholder' => 'Select sectors ...'],
                    'pluginOptions' => [
                        'tags' => true,
                        'tokenSeparators' => [',', ' '],
                        'maximumInputLength' => 10
                    ]]);
                ?>

        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
        <?= $form->field($model, 'qp_code')->textInput(['maxlength' => 15]) ?>

        </div>
        <div class="col-md-6">

        <?= $form->field($model, 'nsqf_level')->textInput([
       'maxlength' => 1,
       'class' => 'numberOnly', 'onkeypress'=>'return onlyNumberKey(event)' ])  ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
        <?= $form->field($model, 'qualification')->textInput()  ?>

        </div>
        <div class="col-md-6">
        <?= $form->field($model, 'theory_hour')->textInput(['min'=>1,'max' => 1000,'class' => 'numberOnly', 'step'=>'0.5','type' => 'number','min'=>1,"onkeyup"=>"calculateTotalhours()","onchange"=>"calculateTotalhours()","onscroll"=>"calculateTotalhours()"]) ?>

        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
    <?= $form->field($model, 'practical_hour')->textInput(['min'=>1,'max' => 1000,'class' => 'numberOnly', 'step'=>'0.5','type' => 'number','min'=>1,"onkeyup"=>"calculateTotalhours()","onchange"=>"calculateTotalhours()","onscroll"=>"calculateTotalhours()"]) ?>

        </div>
        <div class="col-md-6">
    <?= $form->field($model, 'softskill_hour')->textInput(['min'=>1,'max' => 1000,'class' => 'numberOnly', 'step'=>'0.5','type' => 'number','min'=>1,"onkeyup"=>"calculateTotalhours()","onchange"=>"calculateTotalhours()","onscroll"=>"calculateTotalhours()"]) ?>

        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
    <?= $form->field($model, 'not_payable')->textInput(['min'=>1,'max' => 1000,'class' => 'numberOnly', 'step'=>'0.5','type' => 'number','min'=>1,"onkeyup"=>"calculateTotalhours()","onchange"=>"calculateTotalhours()","onscroll"=>"calculateTotalhours()"]) ?>

        </div>
        <div class="col-md-6">
    <?= $form->field($model, 'net_hours') ->textInput(['type' => 'number','min'=>1,"readOnly"=>true]) ?>

        </div>
    </div>












    <div class="form-group text-right">
    <?php $btnName=($model->isNewRecord)?"Create":"Update" ?>
    <?= Html::a('Cancel', ['/job/index'], ['class'=>'btn btn-info grid-button']) ?>


    <?= Html::submitButton(Yii::t('app', $btnName), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>

    function calculateTotalhours(){
        // alert()
    var thour=$('input[name="Job[theory_hour]"]').val()
    var phour=$('input[name="Job[practical_hour]"]').val()
    var shour=$('input[name="Job[softskill_hour]"]').val()
    var nhour=$('input[name="Job[not_payable]"]').val()
    var net=thour/1+phour/1+shour/1;
    if(net<0){
        toastr.error("Insert payable hours first")
        return
    }
    $('input[name="Job[net_hours]"]').val(net.toFixed(2))
    // calculateTotalPrice()
}
    </script>
