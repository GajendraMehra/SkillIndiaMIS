<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
switch (variable) {
  case 'value':
    // code...
    break;

  default:
    // code...
    break;
}
/* @var $this yii\web\View */
/* @var $model app\models\search\SubSector */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sub-sector-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'sub_sector_name') ?>

    <?= $form->field($model, 'sector_id') ?>

    <?= $form->field($model, 'nsdc_sub_sector_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
