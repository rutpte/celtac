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
		<!-- //$('#modal_user').modal('show') -->
		
			<div class="modal fade" id="modal_add_order" tabindex="-1" role="dialog"  aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title">add order</h5><!--  $('#exampleModalLabel').text("aaaaaaaaaaa"); -->
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body" id="modal-body-add_order">
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
							  <label for="username">Username</label>
							  <div class="input-group">
								<div class="input-group-prepend">
								  <span class="input-group-text">@</span>
								</div>
								<input type="text" class="form-control" id="username" placeholder="Username" required>
								<div class="invalid-feedback" style="width: 100%;">
								  Your username is required.
								</div>
							  </div>
							</div>

							<div class="mb-3">
							  <label for="email">Email <span class="text-muted">(Optional)</span></label>
							  <input type="email" class="form-control" id="email" placeholder="you@example.com">
							  <div class="invalid-feedback">
								Please enter a valid email address for shipping updates.
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
							  <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
							  <input type="text" class="form-control" id="address2" placeholder="Apartment or suite">
							</div>

							<div class="row">
							  <div class="col-md-5 mb-3">
								<label for="country">Country</label>
								<select class="custom-select d-block w-100" id="country" required>
								  <option value="">Choose...</option>
								  <option>United States</option>
								</select>
								<div class="invalid-feedback">
								  Please select a valid country.
								</div>
							  </div>
							  <div class="col-md-4 mb-3">
								<label for="state">State</label>
								<select class="custom-select d-block w-100" id="state" required>
								  <option value="">Choose...</option>
								  <option>California</option>
								</select>
								<div class="invalid-feedback">
								  Please provide a valid state.
								</div>
							  </div>
							  <div class="col-md-3 mb-3">
								<label for="zip">Zip</label>
								<input type="text" class="form-control" id="zip" placeholder="" required>
								<div class="invalid-feedback">
								  Zip code required.
								</div>
							  </div>
							</div>
							<hr class="mb-4">
							<div class="custom-control custom-checkbox">
							  <input type="checkbox" class="custom-control-input" id="same-address">
							  <label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
							</div>
							<div class="custom-control custom-checkbox">
							  <input type="checkbox" class="custom-control-input" id="save-info">
							  <label class="custom-control-label" for="save-info">Save this information for next time</label>
							</div>
							<hr class="mb-4">

							<h4 class="mb-3">Payment</h4>

							<div class="d-block my-3">
							  <div class="custom-control custom-radio">
								<input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked required>
								<label class="custom-control-label" for="credit">Credit card</label>
							  </div>
							  <div class="custom-control custom-radio">
								<input id="debit" name="paymentMethod" type="radio" class="custom-control-input" required>
								<label class="custom-control-label" for="debit">Debit card</label>
							  </div>
							  <div class="custom-control custom-radio">
								<input id="paypal" name="paymentMethod" type="radio" class="custom-control-input" required>
								<label class="custom-control-label" for="paypal">PayPal</label>
							  </div>
							</div>
							<div class="row">
							  <div class="col-md-6 mb-3">
								<label for="cc-name">Name on card</label>
								<input type="text" class="form-control" id="cc-name" placeholder="" required>
								<small class="text-muted">Full name as displayed on card</small>
								<div class="invalid-feedback">
								  Name on card is required
								</div>
							  </div>
							  <div class="col-md-6 mb-3">
								<label for="cc-number">Credit card number</label>
								<input type="text" class="form-control" id="cc-number" placeholder="" required>
								<div class="invalid-feedback">
								  Credit card number is required
								</div>
							  </div>
							</div>
							<div class="row">
							  <div class="col-md-3 mb-3">
								<label for="cc-expiration">Expiration</label>
								<input type="text" class="form-control" id="cc-expiration" placeholder="" required>
								<div class="invalid-feedback">
								  Expiration date required
								</div>
							  </div>
							  <div class="col-md-3 mb-3">
								<label for="cc-cvv">CVV</label>
								<input type="text" class="form-control" id="cc-cvv" placeholder="" required>
								<div class="invalid-feedback">
								  Security code required
								</div>
							  </div>
							</div>
							<hr class="mb-4">
							<button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
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
				<div class="col-3"><a href="#" onclick="celtac.g_func.modal_contact()">.col-4</a></div>
				<div class="col-3"><a href="#" onclick="celtac.g_func.modal_contact()">.col-4</a></div>
				</div>
				
				<button class="btn my-2 my-sm-0" type="button" onclick="celtac.g_func.modal_add_order()">add order</button>
				
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