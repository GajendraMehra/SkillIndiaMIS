<?php
use yii\widgets\ActiveForm;
?>

<style>
.bg {
  /* The image used */
  background-image: url("<?= yii::getalias('@web')?>/custom/images/cover.jpg");

  /* Full height */
  height: 100%;

  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}

</style>

<body class="my-login-page" >

	<section class="" id="particles-js" >
		<div class=" " >
			<div class="row justify-content-md-center mt-5">
				<div class="card-wrapper mt-5">
				
					<div class="card fat brounded">
						<div class="card-body">
							<div class="text-center mb-3">
								<img src="<?= yii::getalias('@web')?>/custom/images/logo1.png"  width="100" alt="logo">
							</div>
							<?php 
							$form=ActiveForm::begin(['action' => 'index.php?r=site%2Flogin', "class"=>"my-login-validation" ,'options' => ['method' => 'post']]) ?>
							<!-- <form method="POST"  action="<?= Yii::$app->homeUrl?>?r=site%2Flogin"  id="loginForm" " class="my-login-validation" novalidate=""> -->
								<div class="form-group">
									<label for="email">Username or Mail Address</label>
									<input id="email" type="text"  name="LoginForm[username]" class="form-control" name="email" value="" required autofocus>
									<div class="invalid-feedback help-block ">
										Username is required
									</div>
								</div>

								<div class="form-group">
									<label for="password">Password
										
									</label>
									<input id="password" type="password"  name="LoginForm[password]" value="" class="form-control" required data-eye>
								    <div class="invalid-feedback help-block ">
								    	Password is required
							    	</div>
								</div>
								<div class="form-group">
								
									<?= $form->field($model, 'reCaptcha')->widget(\himiklab\yii2\recaptcha\ReCaptcha::className()) ?>
								    <div class="invalid-feedback help-block ">
								    	Password is required
							    	</div>
								</div>
								<!-- <div class="form-group">
									<label for="password">Password
										
									</label>
									<input id="password" type="password"  name="LoginForm[password]" class="form-control" required data-eye>
								    <div class="invalid-feedback help-block ">
								    	Password is required
							    	</div>
								</div> -->
								
								
								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block">
										Login
									</button>
								</div>
								
								<?php ActiveForm::end() ?>
							<div class="text-center mt-2">
									<a href='javascript:void(0)' id="forgetLink"> Forgot Password? </a>
								</div>
								<div class="text-center mt-2">
									For New Registration <a href='javascript:void(0)' id="newLink">Click Here</a>
								</div>
								<div class="text-center mt-2">
									<span class="m-2 text-dark">Powered by</span></span> <a href="http://utmv.in" target="_blank"><img class="img-thumbnail mt-2" style="margin-top:20px" src="<?= yii::getalias('@web')?>/custom/images/utlogo.png" alt="" srcset="" height="40px" width="100px"></a>
								</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>

		
			<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header  text-center">
							<h5  class="modal-title w-100 text-center" id="exampleModalLabel">
							<span class=" text-center">New Registration</span>
							</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-6 text-center">
								<a href="<?= Yii::$app->homeUrl?>?r=site/tp-signup"">
								<i class="fa fa-building-o fa-5x" aria-hidden="true"></i>
									<h5>For Training Partner</h5>
								</a>
								
								</div>
								<div class="col-6 text-center">
								<a href="http://mis.uksdm.org/app/register/student_reg/signup_student.php">
								<i class="fa fa-user-o fa-5x" aria-hidden="true"></i>
									<h5>For Student</h5>
								</a>
								
								</div>
							</div>
						</div>
						<div class="modal-footer">
						</div>
					</div>
				</div>
			</div>

			<!-- Forget Password Modal -->
			<div class="modal fade" id="forgetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgetPasswordModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-center w-100" id="forgetPasswordModalLabel">Forget Password</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
							<div class="col-12 ">
							<?php ActiveForm::begin(['action' => 'index.php?r=site%2Fforget-password', "class"=>"my-login-validation" ,'options' => ['method' => 'post']]) ?>
							
								<div class="form-group">
									<label for="email">E-Mail Address</label>
									<input id="email" type="email" class="form-control"  name="PasswordResetRequestForm[email]" value="" required autofocus>
									<div class="invalid-feedback">
										Email is invalid
									</div>
									<div class="form-text text-muted">
										By clicking "Reset Password" we will send a password reset link
									</div>
								</div>

								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block">
										Reset Password
									</button>
								</div>
							<?php ActiveForm::end() ?>
							</div>
							</div>
						</div>
						<div class="modal-footer">
							<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
						</div>
					</div>
				</div>
			</div>
<!-- end of forget password  -->
	</section>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
