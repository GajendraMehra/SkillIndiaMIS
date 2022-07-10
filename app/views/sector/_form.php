<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Sector */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="sector-form col-md-8">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nsdc_sector_id')->textinput(['class' => 'numberOnly', 'onkeypress'=>'return onlyNumberKey(event)' ]) ?>
    <?= $form->field($model, 'sector_name')->textinput() ?>

    <div class="form-group text-right">
        <?php $btnName=($model->isNewRecord)?"Create":"Update" ?>
        <?= Html::a('Cancel', ['/sector/index'], ['class'=>'btn btn-info grid-button']) ?>

        <?= Html::submitButton(Yii::t('app', $btnName), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>










