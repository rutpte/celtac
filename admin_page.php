<?php
require dirname(__FILE__) . '/includes/init.inc.php';

 if ($_SESSION['is_superuser'] =='t') {

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
		<script type='text/javascript' src='js/js_index_src.js'></script>
		<!-- Bootstrap core CSS -->
		<!-- <link href="libs/dist/css/bootstrap.min.css" rel="stylesheet"> -->



	</head>

	<body class="text-center">


		<!--- ******************************************************************* -->
		<nav class="navbar navbar-expand-md navbar-dark bg-dark">
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
				<a class="nav-link" id="contact_info" href="#" onclick="celtac.g_func.modal_contact()">contact</a>

			  </li>  
			</ul>

			<button class="btn btn-outline-success my-2 my-sm-0" type="button" id="logout">logout</button>
			<!--<button class="btn my-2 my-sm-0" type="button" onclick="celtac.g_func.modal_user()">user</button>-->
			
		  </div>
		</nav>
		<!-- ************************************************************************************************************** -->
		<!-- //$('#modal_contact').modal('show') -->
		
			<div class="modal fade" id="modal_contact" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="modalLabel">Modal title</h5><!--  $('#exampleModalLabel').text("aaaaaaaaaaa"); -->
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body" id="modal-body-contact">
					<div id= "contact_address"></div>
					<div id= "contact_qrcode"></div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					
				  </div>
				</div>
			  </div>
			</div>
			
		
		<!-- ************************************************************************************************************** -->		
		<!-- //$('#modal_user').modal('show') -->
		
			<!--
			<div class="modal fade" id="modal_user" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="modalLabel">user</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body" id="modal-body-user">
					  <div class="row">
						<div class="col-3">name</div>
						<div class="col-3">email</div>
						<div class="col-3">edit</div>
						<div class="col-3">delete</div>
					  </div>
					  
					  <div class="row">
						<div class="col-3">.col-4</div>
						<div class="col-3">.col-4</div>
						<div class="col-3">.col-4</div>
						<div class="col-3">.col-4</div>
					  </div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					
				  </div>
				</div>
			  </div>
			</div>
			-->
			
		
		<!-- ************************************************************************************************************** -->
		<!-- model user -->
			<div class="modal fade" id="modal_add_user" tabindex="-1" role="dialog"  aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title">new user</h5><!--  $('#exampleModalLabel').text("aaaaaaaaaaa"); -->
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body" id="modal-body-add_user">
						<form class="needs-validation" novalidate>
							<div class="row">
							  <div class="col-md-6 mb-3">
								<label for="firstName">First name</label>
								<input type="text" class="form-control" id="firstName" placeholder="" value="" required>
								<div class="invalid-feedback">
								  Valid first name is required.
								</div>
							  </div>
							  <div class="col-md-6 mb-3">
								<label for="lastName">Last name</label>
								<input type="text" class="form-control" id="lastName" placeholder="" value="" required>
								<div class="invalid-feedback">
								  Valid last name is required.
								</div>
							  </div>
							</div>

							<div class="mb-3">
							  <label for="address">Address</label>
							  <input type="text" class="form-control" id="address" placeholder="1234 Main St" required>
							  <div class="invalid-feedback">
								Please enter your shipping address.
							  </div>
							</div>

							<div class="mb-3">
							  <label for="email">Email</label>
							  <input type="email" class="form-control" id="email" placeholder="you@example.com">
							  <div class="invalid-feedback">
								Please enter a valid email address for shipping updates.
							  </div>
							</div>
							
							<div class="mb-3">
							  <label for="pass">password</span></label>
							  <input type="text" class="form-control" id="pass" placeholder="password">
							</div>

							<hr class="mb-4">
							<button class="btn btn-primary btn-lg btn-block" type="button">Save</button>
						  </form>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					
				  </div>
				</div>
			  </div>
			</div>
		
		
		<!-- ************************************************************************************************************** -->
		<main role="main" class="container">


		  <div>

				<div class="row">
				<div class="col-3">name</div>
				<div class="col-3">email</div>
				<div class="col-3">edit</div>
				<div class="col-3">delete</div>
				</div>

				<div class="row">
				<div class="col-3">.col-4</div>
				<div class="col-3">.col-4</div>
				<div class="col-3"><a href="#" onclick="celtac.g_func.modal_contact()">.col-4</a></div>
				<div class="col-3"><a href="#" onclick="celtac.g_func.modal_contact()">.col-4</a></div>
				</div>

				<button class="btn my-2 my-sm-0" type="button" onclick="celtac.g_func.user('show_model_adduser')">&plus;</button>
				
		  </div>

		</main>

	</body>
	<!--<script type='text/javascript' src='js/js_index_src.js'></script>-->
	<script>
		
		//------------------------------------------------------------------------------------------------
		$( document ).ready(function() {
			console.log( "ready admin page!" );
		});
		
		
	</script>
  
</html>
 <? } else {
		
		header("Location: http://" . $_SERVER['HTTP_HOST'] ."/".PROJ_NAME. "/index.php");
	} 

?>