<?php
	session_start();

	$salt = '2101anhyeuem';
	$stored_hash = 'b5b82597336d984a884d7fab31c8ac1d';

	if (isset($_POST['username']) && isset($_POST['pass'])) {
		unset($_SESSION['username']);

		$check_username = $_POST['username'] === "emma.le2101";
        $check = hash('md5', $salt.$_POST['pass']);
        if ( ($check == $stored_hash) && $check_username ) {
            // Redirect the browser to view.php
            $_SESSION['username'] = $_POST['username'];
            error_log("Login success ".$_POST['username']);
            header("Location: main.php");
            return;
        } 
        else if (!$check_username) {
            $_SESSION['error'] = "Username does not exist";
            error_log("Login fail ".$_POST['username']." $check_username");
            header("Location: index.php");
            return;
        }
        else if ($check != $stored_hash) {
            $_SESSION['error'] = "Incorrect password";
            error_log("Login fail ".$_POST['username']." $check");
            header("Location: index.php");
            return;
        }
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Happy Birthday To My Emma</title>
	<link rel="shortcut icon" href="./images/birthday.ico" />
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/img-01.jpg');">
			<div class="wrap-login100 p-t-190 p-b-30">
				<form method="POST" id="form1" class="login100-form validate-form">
					<div class="login100-form-avatar">
						<img src="images/nhung3.jpg" alt="AVATAR">
					</div>

					<span class="login100-form-title p-t-20 p-b-45">
						Emma Le
					</span>

					<?php
						if (isset($_SESSION['error'])) {
							echo('<p style="color:red;">'.htmlentities($_SESSION['error'])."</p>\n");
							unset($_SESSION['error']);
						}
					?>

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Username is required">
						<input class="input100" type="text" name="username" placeholder="Username">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Password is required">
						<input class="input100" type="password" name="pass" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock"></i>
						</span>
					</div>

					<div class="container-login100-form-btn p-t-10">
						<button type="submit" form="form1" value="Login" class="login100-form-btn">
							Login
						</button>
					</div>

					<div class="text-center w-full p-t-25 p-b-230">
						<a href="#" class="txt1">
							Forgot Username / Password?
						</a>
					</div>

					<div class="text-center w-full">
						<a class="txt1" href="#">
							Create new account
							<i class="fa fa-long-arrow-right"></i>						
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>