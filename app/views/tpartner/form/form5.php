<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use app\models\States;
use app\models\Cities;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\TpdetailAddress */
/* @var $form ActiveForm */
?>

<div class="tpartner-form-form5 mt-4">
    <?php

    $select2Options = [
        'placeholder' => 'Select City',
        'width' => '100%',
    ];

    $validationUrl = ['tpartner/validate'];
    if (!$model->isNewRecord)
        // if the current record xis not new, we will pass "id" for validation in update action.
        $validationUrl['id'] = $model->id;

        $form = ActiveForm::begin([
            'id' => 'tpform-5',
            'action' => ['tpartner/ajax-test'],
            'enableAjaxValidation' => true,
            'validationUrl' => $validationUrl
        ]); ?>


        <div class="row">
            <div class="col-md-6">
            <?= $form->field($model, 'address_line') ?>
            </div>
            <div class="col-md-6">
            <?= $form->field($model, 'post_office') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
            <?= $form->field($model, 'village') ?>
            </div>
            <div class="col-md-6">
            <?= $form->field($model, 'pin_code')->textInput(['class' => 'numberOnly', 
        'onkeypress'=>'return onlyNumberKey(event)'
        ]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
            <?= $form->field($model, 'state_id')->widget(Select2::classname(), [
                    'data' =>   ArrayHelper::map(States::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => 'Select State ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                    'pluginEvents' => [
                        'select2:select' => 'function(e) { populateCityName(e.params.data.id); }',
                    ],
                ]); ?>
            </div>
            <div class="col-md-6">
            <?= $form->field($model, 'city_id')->widget(Select2::className(), [
            'model' => $model,
            'attribute' => 'city_id',
            'data' => ArrayHelper::map(Cities::find()->andWhere(['state_id' =>$model->state_id])->all(), 'id', 'city'),
           
            'options' => $select2Options
        ]); ?>
            </div>
        </div>
      
    <?= $form->field($model, 'id')->hiddenInput(['value'=> $model->id])->label(false); ?>

    <?php ActiveForm::end(); ?>

</div><!-- tpartner-form-form5 -->
<?php ob_start(); ?>
        <script>
            function populateCityName(state_id) {
        var select2Options={
            placeholder: "Select City",
            width: "100%"
        }
        var url = '<?= Url::to(['tpartner/populate-city-name', 'id' => '-id-']) ?>';
        var $select = $('#tpdetailaddress-city_id');
        $select.find('option').remove().end();
        $.ajax({
            url: url.replace('-id-', state_id),
            success: function (data) {
                console.log(data);
               
              
                select2Options.data = data.data;
                console.log($select);
                $select.select2(select2Options);
                $select.val(data.selected).trigger('change');
            }
        });
    }
        </script>
    <?php $this->registerJs(str_replace(['<script>', '</script>'], '', ob_get_clean()), View::POS_END); ?>

