<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SchemeJobs */
/* @var $form ActiveForm */
?>
<div class="scheme-jobform">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'scheme_id') ?>
        <?= $form->field($model, 'job_id') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- scheme-jobform -->
