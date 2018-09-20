<?php
require dirname(__FILE__) . '/includes/init.inc.php';
//var_dump($_SESSION); exit;
?> 
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="logo.jpg">

		<title>celtac order</title>

		<!-- Bootstrap core CSS -->
		<!-- <link href="libs/dist/css/bootstrap.min.css" rel="stylesheet"> -->
		<script type='text/javascript' src='js/js_index_src.js'></script>

		<!-- Custom styles for this template -->
		<link href="css/signin.css" rel="stylesheet">

	</head>

	<body class="text-center">

<?
 if (!isset($_SESSION['email'])) {
?>
		<form class="form-signin" id="login_form">
			<img class="mb-4" src="logo.jpg" alt="" width="72" height="72">
			<h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
			<div><span style="color:#d14" id="error_login_info"></span></div>
			<label for="inputEmail" class="sr-only">Email address</label>
			<input type="email" id="email" class="form-control" placeholder="Email address" required autofocus>
			<label for="inputPassword" class="sr-only">Password</label>
			<input type="password" id="password" class="form-control" placeholder="Password" required>
			<div class="checkbox mb-3">
				<label>
					<input id="remember" type="checkbox" value="remember-me"> Remember me
				</label>
			</div>
			<!-- <button class="btn btn-lg btn-primary btn-block" id="login"type="submit">Sign in</button>-->
			<button class="btn btn-lg btn-primary btn-block" type="button" id="sing_in">Sign in</button>
			<p class="mt-5 mb-3 text-muted">&copy; Celtac Co.,Ltd. <a href="#" style = "color: #757575">| forget password.</a></p>
			
		</form>
<? 
}else if($_SESSION['is_superuser']){
	header("Location: http://" . $_SERVER['HTTP_HOST'] ."/".PROJ_NAME. "/admin_page.php");
} else if($_SESSION['is_staff']){
	header("Location: http://" . $_SERVER['HTTP_HOST'] ."/".PROJ_NAME. "/staff_page.php");
} else {
	header("Location: http://" . $_SERVER['HTTP_HOST'] ."/".PROJ_NAME. "/customer_page.php");
}
?>
	</body>
</html>
