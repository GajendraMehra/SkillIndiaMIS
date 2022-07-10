<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

$this->title = "Give Reason";
$this->params['breadcrumbs'][] = ['label' => 'Tranche Details', 'url' => ['view','id'=>$model->id]];
$this->params['breadcrumbs'][] = $this->title;

?>


<div class="card card-primary border-info">
    <div class="card-header text-white bg-<?= Yii::$app->config->get('panel-theme','primary')?>">
    <h5><?= $this->title ?></h5>
    </div>
    <div class="card-body col-md-6">

        <?php
        
        $form = ActiveForm::begin(
            [
                'method'=>'POST',
            'action' => 'index.php?r=trans/forward&id='.$model->id ,
            'options' => [
                'class' => 'userform'
             ]
            ]

        );  
       echo $form->field($model, 'status')->hiddenInput(['value'=> 2])->label(false);
?>
    <?= $form->field($model, 'message_admin')->textArea(['rows'=>5,'required'=>true])->label("Give Reason for Dening Tranche") ?>
     
        <div class="form-group text-right">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
