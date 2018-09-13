<?php
require dirname(__FILE__) . '/includes/init.inc.php';
//session_destroy();
//var_dump($_SESSION['username']); exit;
 if (isset($_SESSION['username'])) {

?> 
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="logo.jpg">

		<title>customer page</title>
		<script type='text/javascript' src='js/js_index_src.js'></script>
		<!-- Bootstrap core CSS -->
		<!-- <link href="libs/dist/css/bootstrap.min.css" rel="stylesheet"> -->



	</head>

	<body class="text-center">


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
				<a class="nav-link" id="contact_info" href="#" onclick="celtac.g_func.modal_contact()">contact</a>

			  </li>  
			</ul>

			<button class="btn btn-outline-success my-2 my-sm-0" type="button" id="logout">logout</button>
			<button class="btn my-2 my-sm-0" type="button" onclick="celtac.g_func.modal_user()">user</button>
			
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
		
			<div class="modal fade" id="modal_user" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="modalLabel">user</h5><!--  $('#exampleModalLabel').text("aaaaaaaaaaa"); -->
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
			
		
		<!-- ************************************************************************************************************** -->
		<main role="main" class="container">

		  <div class="starter-template">
			<h1>Bootstrap starter template</h1>
			<p class="lead">Use this document as a way to quickly start any new project.<br> All you get is this text and a mostly barebones HTML document.</p>
			
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
				
				<button class="btn my-2 my-sm-0" type="button" onclick="celtac.g_func.modal_add_order()">add</button>
				
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