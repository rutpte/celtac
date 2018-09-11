<?php
require dirname(__FILE__) . '/includes/init.inc.php';
?> 
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="logo.jpg">

		<title>Signin Template for Bootstrap</title>

		<!-- Bootstrap core CSS -->
		<!-- <link href="libs/dist/css/bootstrap.min.css" rel="stylesheet"> -->

		<!-- Custom styles for this template -->
		<link href="css/signin.css" rel="stylesheet">

	</head>

	<body class="text-center">

<?
 if (!isset($_SESSION['username'])) {
//!isset($_SESSION['username'])

?>
		<form class="form-signin" id="login_form">
			<img class="mb-4" src="logo.jpg" alt="" width="72" height="72">
			<h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
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
			<p class="mt-5 mb-3 text-muted">&copy; Celtac Co.,Ltd.</p>
		</form>
<? 
 } else {
?>
		<!--- ******************************************************************* -->
		<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
		  <a class="navbar-brand" href="#">Celtac</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		  </button>

		  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
			<ul class="navbar-nav mr-auto">
			  <li class="nav-item active">
				<a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" id="contact_info" href="#" data-toggle="modal" data-target="#modal" onclick="celtac.g_func.modal_contact(); return:false;">contact</a>

			  </li>  
			</ul>

			<button class="btn btn-outline-success my-2 my-sm-0" type="button" id="logout">logout</button>
			<button class="btn my-2 my-sm-0" type="button">user</button>
			
		  </div>
		</nav>
		<!-- ************************************************************************************************************** -->
		<!-- //$('#modal').modal('show') -->
			<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Modal title</h5><!--  $('#exampleModalLabel').text("aaaaaaaaaaa"); -->
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body" id="modal-body">
					...
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					
				  </div>
				</div>
			  </div>
			</div>
			
		
		<!-- ************************************************************************************************************** -->
		<main role="main" class="container">

		  <div class="starter-template">
			<h1>Bootstrap starter template</h1>
			<p class="lead">Use this document as a way to quickly start any new project.<br> All you get is this text and a mostly barebones HTML document.</p>
		  </div>

		</main>
<?
 }
?>
	</body>
	<script type='text/javascript' src='js/js_index_src.js'></script>
	<script>
		
		//------------------------------------------------------------------------------------------------
		$( document ).ready(function() {
			console.log( "ready!" );
		});
		
		
	</script>
  
</html>
