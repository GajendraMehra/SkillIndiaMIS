<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

use kartik\widgets\FileInput;
/* @var $this yii\web\View */
/* @var $model app\models\AccountantData */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="accountant-data-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'file_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'file_description')->textArea(['maxlength' => true]) ?>
    <?php
    if ($model->isNewRecord) {
     echo $form->field($model, 'file_image')->widget(FileInput::classname(), [
        'name'=>'file_image',
        'options' => ['accept' => ['image/*','/pdf','required'=>true]],
         'pluginOptions'=>[
             
            'allowedFileExtensions'=>['jpg','jpeg','png','pdf','xls','docx','doc'],'showUpload' => false,
    
         'showCaption' => false,
         'showRemove' => true,
         'showUpload' => false,
         'showCancel' => false,
         'browseClass' => 'btn btn-primary btn-sm',
        //  'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
         'browseLabel' =>  'Choose File'
        ],
    ])->label("Upload File");
    }

    ?>

   

    <div class="form-group text-right">
        <?= Html::submitButton('Upload and Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
