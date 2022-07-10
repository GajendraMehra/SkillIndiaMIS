<?php
   use yii\bootstrap\ActiveForm;
   use yii\bootstrap\Html;
?>

<div class="row mt-3">
<div class="col-md-8">
<?php $form = ActiveForm::begin(['id' => 'registration-form']); ?>
 
    <div class="form-group row">
        <label for="host" class="control-label col-sm-2">Host</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="mail[mail-host]" class="text-uppercase"  placeholder="Host" value="<?= Yii::$app->config->get('mail-host'); ?>">
        </div>
    </div>


    <div class="form-group row">
        <label for="username" class="control-label col-sm-2">Username</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="mail[mail-username]" class="text-uppercase"  placeholder="Username" value="<?= Yii::$app->config->get('mail-username'); ?>">
        </div>
    </div>


    <div class="form-group row">
        <label for="password" class="control-label col-sm-2">Password</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" name="mail[mail-password]" class="text-uppercase"  placeholder="Password" value="<?= Yii::$app->config->get('mail-password'); ?>">
        </div>
    </div>


    <div class="form-group row">
        <label for="fname" class="control-label col-sm-2">Port</label>
        <div class="col-sm-10">
          <input type="number" class="form-control" name="mail[mail-port]" class="text-uppercase"  placeholder="Port Number" value="<?= Yii::$app->config->get('mail-port',587); ?>">
        </div>
    </div>


    <div class="form-group row">
        <label for="encryption" class="control-label col-sm-2">Encryption</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="mail[mail-encryption]" class="text-uppercase"  placeholder="MIS Name" value="<?= Yii::$app->config->get('mail-encryption','tls'); ?>">
        </div>
    </div>



    
    <div class="form-group text-right">
        <?= Html::submitButton(Yii::t('app', "Update"), ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>



</div>

</div>

