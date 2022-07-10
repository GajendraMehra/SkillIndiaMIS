<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\Tcdetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tcdetail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'smart_tcid') ?>

    <?= $form->field($model, 'is_pmkk') ?>

    <?= $form->field($model, 'tcenter_type') ?>

    <?php // echo $form->field($model, 'is_hostel') ?>

    <?php // echo $form->field($model, 'hostel_capacity') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'tp_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'edited_by') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
