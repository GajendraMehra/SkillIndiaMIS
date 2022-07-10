<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Url;
use aryelds\sweetalert\SweetAlert;

use app\assets\AppAsset;
use app\assets\DashboardAsset;
use yii\helpers\Html;


DashboardAsset::register($this);
?>
<style>

</style>
<div class="row">

<div class="login-box" style="margin:auto">
  <div class="login-logo">
      <img src="custom/images/logo1.png" width="200px" height="200px" alt="" srcset="">
    <!-- <a href="../../index2.html"><b>Admin</b>LTE</a> -->
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

      <form action="index.php?r=site/forget-password" method="post">
        <div class="input-group mb-3">
          <input type="email" required class="form-control" name="PasswordResetRequestForm[email]" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Request new password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-1">
      <a href="index.php?r=site/" class="btn btn-success"><span class="fa fa-backward"></span> Back to Login</a>

      
      </p>
      <!-- <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> -->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
</div>