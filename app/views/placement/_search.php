<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\StudentPlacement */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-placement-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'batch_id') ?>

    <?= $form->field($model, 'student_id') ?>

    <?= $form->field($model, 'result') ?>

    <?= $form->field($model, 'placed_organisation') ?>

    <?php // echo $form->field($model, 'package_pm') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
