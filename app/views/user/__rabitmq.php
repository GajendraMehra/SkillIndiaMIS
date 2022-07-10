<?php
   use yii\bootstrap\ActiveForm;
   use yii\bootstrap\Html;
?>

<div class="row mt-3">
<div class="col-md-8">
<?php $form = ActiveForm::begin(['id' => 'registration-form']); ?>

    <div class="form-group row">
        <label for="host" class="control-label col-sm-2">Server Host</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="rabitmq[rabitmq-host]" class="text-uppercase"  placeholder="Host" value="<?= Yii::$app->config->get('rabitmq-host'); ?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="host" class="control-label col-sm-2">RabbitMQ Port</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="rabitmq[rabitmq-port]" class="text-uppercase"  placeholder="Host" value="<?= Yii::$app->config->get('rabitmq-port'); ?>">
        </div>
    </div>


    <div class="form-group row">
        <label for="username" class="control-label col-sm-2">Username</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="rabitmq[rabitmq-username]" class="text-uppercase"  placeholder="Username" value="<?= Yii::$app->config->get('rabitmq-username'); ?>">
        </div>
    </div>


    <div class="form-group row">
        <label for="password" class="control-label col-sm-2">Password</label>
        <div class="col-sm-10">
          <input type="password" class="form-control" name="rabitmq[rabitmq-password]" class="text-uppercase"  placeholder="Password" value="<?= Yii::$app->config->get('rabitmq-password'); ?>">
        </div>
    </div>

    <div class="form-group row">
        <label for="password" class="control-label col-sm-2">Virtual Host</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="rabitmq[rabitmq-vhost]" class="text-uppercase"  placeholder="Virtual Host" value="<?= Yii::$app->config->get('rabitmq-vhost'); ?>">
        </div>
    </div>

    <div class="form-group row">
        <label for="password" class="control-label col-sm-2">Receiving Host</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="rabitmq[rabitmq-rhost]" class="text-uppercase"  placeholder="Virtual Host" value="<?= Yii::$app->config->get('rabitmq-rhost'); ?>">
        </div>
    </div>


    <div class="form-group text-right">
        <?= Html::submitButton(Yii::t('app', "Update"), ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>

</div>

</div>
