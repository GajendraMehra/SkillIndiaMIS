<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use app\models\Job ;
use app\models\TpartnerDetail;
use app\models\SchemeJobs;
use app\models\Cities;
use app\models\UkDistrict;
use app\models\Scheme;
use app\models\Sector;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\widgets\FileInput;
/* @var $this yii\web\View */
/* @var $model app\models\Targets */
/* @var $form yii\widgets\ActiveForm */
$yearDrop=[];
for ($i=0; $i < 12; $i++) { 
    $low=2021+$i;
    $up=2021%100+$i+1;
  $yearDrop[2021+$i]= $low ."-".$up;   
}
?>

<div class="targets-form col-md-8">

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
  
     <?= $form->field($model, 'year')->textInput()->widget(Select2::classname(), [
           'data' => $yearDrop,
        'options' => ['placeholder' => 'Select Finanace Year...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
        'pluginEvents' => [
            'select2:select' => 'function(e) { reset(); }',
        ],

    ]) ?>
     <?= $form->field($model, 'scheme_id')->textInput()->widget(Select2::classname(), [
        'data' =>   ArrayHelper::map(Scheme::find()->all(), 'id', 'full_name'),
        'options' => ['placeholder' => 'Select Scheme...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
        'pluginEvents' => [
            'select2:select' => 'function(e) { reset(); }',
        ],

    ]) ?>


<?= $form->field($model, 'tp_id')->textInput()->widget(Select2::classname(), [
'data' =>   ArrayHelper::map(TpartnerDetail::find()->where(['is_approved'=>1])->all(), 'id', 'tp_name'),
'options' => ['placeholder' => 'Select Training Partner...'],
'pluginOptions' => [
    'allowClear' => true
],
'pluginEvents' => [
    'select2:select' => 'function(e) { reset(); }',
],

]) ?>

<?=  $form->field($model1, 'district_id')->widget(Select2::classname(), [
   'language' => 'en',
   'name' => 'district_id',
   'data' =>   ArrayHelper::map(UkDistrict::find()->orderBy(['name'=>SORT_ASC])->all(), 'id', 'name'),
   'value'=>502,

   'options' => ['placeholder' => 'Select Multiples districts','required'=>true],
   'pluginOptions' => [
        // 'tags' => $row,
        'allowClear' => true,
        'multiple' => true
    ],
])->label('Select Districts'); ?>

<?=  $form->field($model2, 'job_id')->widget(Select2::classname(), [
   'language' => 'en',
   'name' => 'job_id',
   'data' =>   ArrayHelper::map(Job::find()->all(), 'id', 'job_name'),
    'value'=>[2],
   'options' => ['placeholder' => 'Select Multiples jobs ','required'=>true],
   'pluginOptions' => [
        // 'tags' => $row,
        'allowClear' => true,
        'multiple' => true
    ],
])->label('Select Jobs'); ?>
<?= $form->field($model, 'number')->textInput([
       'maxlength' => 9,
       'class' => 'numberOnly', 'onkeypress'=>'return onlyNumberKey(event)' ])  ?>
<?php

echo  $form->field($model, 'imageFile')->widget(FileInput::classname(), [
    'name'=>'imageFile',
    'options' => ['accept' => ['image/*','/pdf','required'=>true]],
     'pluginOptions'=>['allowedFileExtensions'=>['jpg','jpeg','png','pdf'],'showUpload' => false,

     'showCaption' => false,
     'showRemove' => true,
     'showUpload' => false,
     'showCancel' => false,
     'browseClass' => 'btn btn-primary',
    //  'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
     'browseLabel' =>  'Select Work Order'
    ],
]);

?>

    <div class="form-group text-right mt-2">
    <?php $btnName=($model->isNewRecord)?"Create":"Update" ?>

    <?= Html::a('Cancel', ['/target/index'], ['class'=>'btn btn-info grid-button']) ?>

        <?= Html::submitButton(Yii::t('app', $btnName), ['id'=> "save_btn",'class' => 'btn grid-button btn-success',

        'data' => [
            'confirm' => Yii::t('app', 'Are you sure you want to create this target . Once created can not be modified  '),
            'method' => 'post',
        ],
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
function reset() {
$('select[name="sector_id"]').select2('val',(0).toString())
$('select[name="Targets[job_id]"]').select2('val',(0).toString())

}

//
</script>
