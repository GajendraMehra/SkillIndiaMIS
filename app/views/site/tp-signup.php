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

<body class="my-login-page">
	<section class=""  id="particles-js">
		<div class="container ">
			<div class="row justify-content-md-center ">
				<div class="card-wrapper mt-5">
					
					<div class="card fat rounded-5">
						<div class="card-body">
							<div class="text-center mb-3">
								<img src="<?= yii::getalias('@web')?>/custom/images/logo1.png"  width="100" alt="logo">
							</div>
							<?php ActiveForm::begin(['action' => 'index.php?r=site%2Fsignup', "class"=>"my-login-validation" ,'options' => ['method' => 'post']]) ?>
							
								<div class="form-group">
									<label for="name">Username</label>
									<input id="name" type="text" class="form-control" name="SignupForm[username]" required autofocus>
									<div class="invalid-feedback">
										Username is required
									</div>
								</div>

								<div class="form-group">
									<label for="email">E-Mail Address</label>
									<input id="email" type="email" class="form-control" name="SignupForm[email]" required>
									<div class="invalid-feedback">
										Your email is invalid
									</div>
								</div>

								<div class="form-group">
									<label for="password">Password</label>
									<input id="password" type="password" class="form-control" name="SignupForm[password]"  required data-eye>
									<div class="invalid-feedback">
										Password is required
									</div>
								</div>

								<div class="form-group">
									<div class="custom-checkbox custom-control">
										<input type="checkbox" name="agree" id="agree" class="custom-control-input" required="">
										<label for="agree" class="custom-control-label">I agree to the <a href="#">Terms and Conditions</a></label>
										<div class="invalid-feedback">
											You must agree with our Terms and Conditions
										</div>
									</div>
								</div>

								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block">
										Register
									</button>
								</div>
								<div class="mt-4 text-center">
									Already have an account? <a href="<?= Yii::$app->homeUrl?>?r=site/login">Login</a>
								</div>
							<?php ActiveForm::end() ?>
							<div class="text-center mt-2">
									<span class="m-2 text-dark">Powered by</span></span> <a href="http://utmv.in" target="_blank"><img class="img-thumbnail mt-2" style="margin-top:20px" src="<?= yii::getalias('@web')?>/custom/images/utlogo.png" alt="" srcset="" height="40px" width="100px"></a>
								</div>
						
						</div>
					</div>
					
				</div>
			</div>
		</div>

		

<!-- end of forget password  -->
	</section>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	
</body>