<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\CommonModel;
use app\models\BatchStudents;

use app\models\TargetBatch;
/* @var $this yii\web\View */
/* @var $model app\models\StudentPlacement */
/* @var $form yii\widgets\ActiveForm */
$tcdetail=CommonModel::getTcdetailbyuserid();

?>

<div class="student-placement-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'batch_id')->textInput()->widget(Select2::classname(), [
                    'data' =>   ArrayHelper::map(TargetBatch::find()->all(), 'id', 'batch_name'),
                    'options' => ['placeholder' => 'Select Batch '],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                   
                   
        ]); ?>
 
 <?= $form->field($model, 'student_id')->textInput()->widget(Select2::classname(), [
                    'data' =>   ArrayHelper::map(BatchStudents::find()->where(['batch_id'=>$model->batch_id])->all(), 'student_id',function($model){
                        return $model->student->student_name ." ( ".$model->student->sip_id ." )";
                    }),
                    'options' => ['placeholder' => 'Select Batch '],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                   
                   
        ]); ?>


    <!-- <?= $form->field($model, 'result')->textInput() ?> -->

    <?= $form->field($model, 'placed_organisation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'package_pm')->textInput() ?>

    <div class="form-group text-right">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
