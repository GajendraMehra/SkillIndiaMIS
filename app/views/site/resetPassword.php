<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>


</style>
<div class="site-reset-password login-page">
<div class="row">

<div class="col-md-4" style="margin:auto">

<div class="login-box">
<div class="login-logo">
      <img src="custom/images/logo1.png" width="200px" height="200px" alt="" srcset="">
    <!-- <a href="../../index2.html"><b>Admin</b>LTE</a> -->
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>

      <?php $form = ActiveForm::begin(['id' => 'login-form','method'=>'POST']); ?>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="ResetPasswordForm[password]" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="ResetPasswordForm[passconf]" class="form-control" placeholder="Confirm Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Change password</button>
          </div>
          <!-- /.col -->
        </div>
        <?php ActiveForm::end(); ?>

      <p class="mt-3 mb-1">
      <a href="index.php?r=site/" class="btn btn-success"><span class="fa fa-backward"></span> Back to Login</a>

      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
</div>

</div>
</div>
