<?php 
use app\assets\DashboardAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\rbac\DbManager;
use kartik\form\ActiveForm; 
 
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <style>
        * {
  box-sizing: border-box;
}
body {
  margin: 0;
  font-family: sans-serif;
}
a {
  color: #666;
  font-size: 14px;
  display: block;
}
.logo {
  width: 190px;
  height: 60px;
  background: #DDD;
}
.login-title {
  flex-basis: 100%;
}
#login-page {
  display: flex;
}
.login {
  width: 30%;
  height: 100vh;
  background: #FFF;
  padding: 50px;
  display: block;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  align-content: center;
  text-align: center;
}
.login a {
  margin-top: 25px;
}
.form-login label {
  text-align: left;
  font-size: 13px;
  margin-top: 5px;
  display: block;
  color: #666;
}
/* .input-text,
.input-password {
  width: 100%;
  background: #DDD;
  border-radius: 5px;
  margin: 4px 0 8px 0;
  padding: 10px;
  float: left;
  display: flex;
} */
.icon {
  padding: 4px;
  color: #666;
  min-width: 30px;
  text-align: center;
}
/* input[type="text"],
input[type="password"] {
  width: 100%;
  border: 0;
  background: none;
  font-size: 16px;
  padding: 4px 0;
  outline: none;
} */
input[type="submit"] {
  width: 100%;
  border: 0;
  border-radius: 25px;
  padding: 14px;
  background: #008552;
  color: #FFF;
  display: inline-block;
  cursor: pointer;
  font-size: 16px;
  font-weight: bold;
  margin-top: 10px;
}

.background {
  width: 70%;
  padding: 40px;
  height: 100vh;
  background: linear-gradient(60deg, rgba(158, 189, 19, 0.5), rgba(0, 133, 82, 0.7)), url('http://www.nationalskillsnetwork.in/wp-content/uploads/2018/03/skill-india-empowers-35-lakh-women.jpg') center no-repeat;
  background-size: cover;
  display: flex;
  flex-wrap: wrap;
  align-items: flex-end;
  justify-content: flex-end;
  align-content: center;
  flex-direction: row;
}
.background h1 {
  max-width: 420px;
  color: #FFF;
  text-align: right;
  padding: 0;
  margin: 0;
}
.background p {
  max-width: 650px;
  color: #DDD;
  font-size: 15px;
  text-align: right;
  padding: 0;
  margin: 15px 0 0 0;
}
.madeby {
  position: absolute;
  bottom: 30px;
  right: 40px;
}
.madeby p {
  font-weight: bold;
  color: #9EBD13;
}
.madeby a {
  color: #222;
  text-decoration: none;
}
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css">
</head>
<body>
<div id="login-page">
<?= $this->render('/layouts/flashes'); ?>
    
  <div class="login" style="margin:0px auto;">
    <h2 class="login-title"><img src="custom/images/logo1.png" alt="" width="150px" height="150px" srcset=""></h2>
    <!-- <form class="form-login" action="/backend/web/index.php?r=site%2Flogin1" method="POST">
      <label for="text">Username</label>
      <div class="input-text">
        <i class="fas fa-envelope icon"></i>
        <input type="text" name="LoginForm[username]" value="admin" placeholder="Enter your Username">
      </div>
      <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
      <label for="password">Password</label>
      <div class="input-password">
        <i class="fas fa-lock icon"></i>
        <input type="password" value="skillindiaadmin" name="LoginForm[password]" placeholder="enter your password">
      </div>
      <div class="help-block invalid-feedback"></div>
      <input type="submit" name="login-button" value="Login">
    </form> -->
    <div class="text-left">
    <?php
    
        $form = ActiveForm::begin([
            'id' => 'login-form-vertical', 
            'type' => ActiveForm::TYPE_VERTICAL
        ]); 
        $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>
        </div>
        <div class="form-group text-right">
        <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        <?php ActiveForm::end(); ?>
        </div>
        <div>
        <a href="#">Forget your password ?</a>
        <a href="http://utmv.in" target="_blank">  Powered  <i class="fa fa-heart"></i> by  <img class="img-thumbnail" src="custom/images/utlogo.png" alt="" srcset="" height="50px" width="100px"> </a>
        </div>
 
</div>

<script>
 
</script>
</body>
</html>