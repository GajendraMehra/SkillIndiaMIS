<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TargetsResponse */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="targets-response-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'target_id')->textInput() ?>

    <?= $form->field($model, 'tc_id')->textInput() ?>

    <?= $form->field($model, 'response_number')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'edited_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
