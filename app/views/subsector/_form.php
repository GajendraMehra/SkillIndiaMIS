<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use app\models\Sector;
// use app\models\TpartnerDetail;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\SubSector */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sub-sector-form col-md-8">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nsdc_sub_sector_id')->textInput() ?>
    <?= $form->field($model, 'sub_sector_name')->textInput() ?>

    <?= $form->field($model, 'sector_id')->textInput()->widget(Select2::classname(), [
           'data' =>   ArrayHelper::map(Sector::find()->all(), 'nsdc_sector_id', 'sector_name'),
           'maintainOrder' => true,
           'options' => ['placeholder' => 'Select sectors ...'],
           'pluginOptions' => [
               'tags' => true,
               'tokenSeparators' => [',', ' '],
               'maximumInputLength' => 10
           ]]);
       ?>


    <div class="form-group text-right">
      <?php $btnName=($model->isNewRecord)?"Create":"Update" ?>
      <?= Html::a('Cancel', ['/subsector/index'], ['class'=>'btn btn-info grid-button']) ?>

        <?= Html::submitButton($btnName, ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
