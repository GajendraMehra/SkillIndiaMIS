<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\RateInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rate-info-form col-md-8">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fromdate')->widget(DatePicker::classname(), [
          'options' => ['placeholder' => 'Select from date ...'],
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]
        ]) ?>
    <?php

  
    ?>
    <?= $form->field($model, 'rate_amount')->textInput(['maxlength' => 10,'class' => 'numberOnly', 
        'onkeypress'=>'return onlyDecimalKey(event)'
        ]) ?>

    <div class="form-group text-right">
        <?= Html::a('Cancel', ['/rate/view','id'=>$model->rate->id], ['class'=>'btn btn-info grid-button']) ?>

        <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-success','data' => [
                        'confirm' => Yii::t('app', 'Please Review the amount and date carefully. Once updated amount can not be modified in future '),
                        'method' => 'post',
                    ],]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
