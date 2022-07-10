<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use app\models\TargetBatch;
use app\models\CommonModel;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\TransDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="trans-detail-form col-8">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'batch_id')->textInput()->widget(Select2::classname(), [
                    'data' =>  ArrayHelper::map(TargetBatch::find()->where(['tc_id'=>$model->tc_id,'final_submit'=>1])->all(), 'id', 'batch_name'),
                    'options' => ['placeholder' => 'Select Batch'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>

    <?= $form->field($model, 'claim_type')->textInput()->widget(Select2::classname(), [
                    'data' => CommonModel::getTransStage(),
                    'options' => ['placeholder' => 'Select Tranche Stage...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>




    <div class="form-group text-right">
        <?= Html::submitButton('Claim', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
