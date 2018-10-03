<?php
require dirname(__FILE__) . '/includes/init.inc.php';
 if (isset($_SESSION['email'])) {
	$obj 	= new Order($pdo);
	$rs_arr = $obj->getOrder();
	//print_r($rs); exit;
	//print_r($value['name']);exit;
	
	 // echo '<pre>';
	// foreach ($rs_arr as &$value) {
		// print_r($value);
	// }
	// exit;
	//---------------------
	$arr_key = array();
	foreach ($rs_arr as &$value) {
		$arr_key[$value['id']] = $value;
	}
	
	// echo '<pre>';
	// print_r($arr_key);
	// exit;



?> 
<script>
 var obj_all_order = <?php echo json_encode($arr_key) ?>
 
</script>

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
		<link href="css/css.css" rel="stylesheet">



	</head>

	<body class="text-center">


		<!--- **************************** nav bar *************************************** -->
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
		<!-- ***************************************** modal_contact ********************************************************************* -->
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
			

		<!-- ************************************** modal_view_order ************************************************************************ -->
		<!-- model view order -->
			<div class="modal fade" id="modal_view_order" tabindex="-1" role="dialog"  aria-hidden="true"   style="overflow-y: scroll">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title">view order</h5><!--  $('#exampleModalLabel').text("aaaaaaaaaaa"); -->
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body" id="modal-body-view_order">
						<form class="needs-validation" novalidate>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="order_code_view">order_code</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="order_code_view" placeholder="CT-09/23">
									</div>
								</div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="customer_name_view">customer</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="customer_name_view" placeholder="customer name">
									</div>
								</div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="product_type_view">product type</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="product_type_view" placeholder="customer name">
									</div>
								</div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="quantity_view">quantity</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="quantity_view" placeholder="quantity">
									</div>
								</div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="vial_view">vial</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="vial_view" placeholder="vial">
									</div>
								</div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="total_cel_view">total_cel</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="total_cel_view" placeholder="total of cel">
									</div>
								</div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="package_type_view">package</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="package_type_view" placeholder="package_type">
									</div>
								</div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="delivery_date_view">delivery date</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="delivery_date_view" placeholder="date">
									</div>
								</div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="giveaway_view">giveaway</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="giveaway_view" placeholder="giveaway">
									</div>
								</div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="sender_view">sender</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="sender_view" placeholder="sender">
									</div>
								</div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="receiver_view">receiver</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="receiver_view" placeholder="receiver">
									</div>
								</div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="dealer_person_view">dealer_person</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="dealer_person_view" placeholder="dealer person">
									</div>
								</div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="dealer_company_view">dealer_company</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="dealer_company_view" placeholder="dealer company">
									</div>

							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="price_rate_view">price_rate</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="price_rate_view" placeholder="price rate">
									</div>
								</div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="comment_else_view">comment_else</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="comment_else_view" placeholder="comment" disabled>
									</div>
								</div>
							</div>
							<hr class="mb-4">
							<!-- <button class="btn btn-primary btn-lg btn-block" id="bt_save_edit_order" type="button" onclick="celtac.g_func.order('edit_order',"+obj_all_order[25].id+")">Save</button> -->
							<!-- <div class="col-1"><a href="#" onclick="celtac.g_func.order('edit_order_model')"><span class="ui-icon ui-icon-pencil"></span></p></a></div> -->
							<button class="btn btn-lg btn-block" type="button" onclick="celtac.g_func.order('edit_order_model')"><span class="ui-icon ui-icon-pencil"></button>
							<input id="order_id_view" type="hidden" value="">
						  </form>
						  
						  
				  </div>
				  <div class="modal-footer">
					
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					
				  </div>
				</div>
			  </div>
			</div>
		</div>
		<!-- ********************************************* modal_add_order_edit ***************************************************************** -->
		<!-- model order edit-->
			<div class="modal fade" id="modal_add_order_edit" tabindex="-1" role="dialog"  aria-hidden="true"   style="overflow-y: scroll">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title">order edit</h5><!--  $('#exampleModalLabel').text("aaaaaaaaaaa"); -->
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body" id="modal-body-add_order_edit">
						<form class="needs-validation" novalidate>
							<div>
								<div class="row">
									<div class="col-4">
										<label for="order_code_edit">order_code</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="order_code_edit" placeholder="CT-09/23">
									</div>
								</div>
								<div id="order_code_vlid_edit"></div>
								
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="customer_name_edit">customer</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="customer_name_edit" placeholder="customer name">
									</div>
								</div>
								<div id="customer_name_vlid_edit"></div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="product_type_edit">product type</label>
									</div>
									
									<div class="col-8">
										<select class="custom-select d-block w-100" id="product_type_edit" required>
											<option value="cell">Cell</option>
											<option value="prp_ready">PRP Ready</option>
											<option value="placenta">Placenta</option>
										</select>
									</div>
								</div>
								<div id="product_type_vlid_edit"></div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="quantity_edit">quantity</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="quantity_edit" placeholder="quantity">
									</div>
								</div>
								<div id="quantity_vlid_edit"></div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="vial_edit">vial</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="vial_edit" placeholder="vial">
									</div>
								</div>
								<div id="vial_vlid"></div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="total_cel_edit">total_cel</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="total_cel_edit" placeholder="total of cel">
									</div>
								</div>
								<div id="total_cel_vlid_edit"></div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="package_type_edit">package</label>
									</div>
									
									<div class="col-8">
										<select class="custom-select d-block w-100" id="package_type_edit" required>
											<option value="ID">ID</option>
											<option value="IV">IV</option>
										</select>
									</div>
								</div>
								<div id="package_vlid"></div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="delivery_date_edit">delivery date</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="delivery_date_edit" placeholder="date">
									</div>
								</div>
								<div id="delivery_date_vlid_edit"></div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label>delivery time</label>
									</div>
									
									<div class="col-8">
										<div class="row">
											<div class="col-6">
												<select class="custom-select" id="delivery_time_hour_edit" required>
													
													<?php 
														$h = 0;
														while ($h<=23) {

													?>
															<option value=<?php echo $h?>><?php echo $h ?></option>
													<?php 
															$h = $h+1;
														}

													?>
												</select>
											</div>
											<div class="col-6">
												<select class="custom-select" id="delivery_time_minute_edit" required>
													<?php 
														$min = 0;
														while ($min<=59) {

													?>
															<option value=<?php echo $min?>><?php echo $min?></option>
													<?php 
															$min = $min+1;
														}

													?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div id="delivery_time_hour_vlid_edit"></div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="giveaway_edit">giveaway</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="giveaway_edit" placeholder="giveaway">
									</div>
								</div>
								<div id="giveaway_vlid_edit"></div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="sender_edit">sender</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="sender_edit" placeholder="sender">
									</div>
								</div>
								<div id="sender_vlid_edit"></div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="receiver_edit">receiver</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="receiver_edit" placeholder="receiver">
									</div>
								</div>
								<div id="receiver_vlid_edit"></div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="dealer_person_edit">dealer_person</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="dealer_person_edit" placeholder="dealer person">
									</div>
								</div>
								<div id="dealer_person_vlid_edit"></div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="dealer_company_edit">dealer_company</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="dealer_company_edit" placeholder="dealer company">
									</div>
								</div>
								<div id="dealer_company_vlid_edit"></div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="price_rate_edit">price_rate</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="price_rate_edit" placeholder="price rate">
									</div>
								</div>
								<div id="price_rate_vlid_edit"></div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="comment_else_edit">comment_else</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="comment_else_edit" placeholder="comment">
									</div>
								</div>
								<div id="comment_else_vlid_edit"></div>
							</div>
							<!-- **************************************** -->
							<hr class="mb-4">
							<button class="btn btn-primary btn-lg btn-block" id="bt_save_update_order"  type="button" onclick="celtac.g_func.order('edit_order')">update</button>
							<input id="order_id_edit" type="hidden" value="">
							<!-- **************************************** -->
						  </form>
						  
						  
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					
				  </div>
				</div>
			  </div>
			</div>
		<!-- ************************************** modal_add_order ************************************************************************ -->
		<!-- model order -->
			<div class="modal fade" id="modal_add_order" tabindex="-1" role="dialog"  aria-hidden="true"  style="overflow-y: scroll">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title">new order</h5><!--  $('#exampleModalLabel').text("aaaaaaaaaaa"); -->
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body" id="modal-body-add_order"   style="overflow-y: scroll">
						<form class="needs-validation" novalidate>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="order_code">order_code</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="order_code" placeholder="CT-09/23">
									</div>
								</div>
								<div id="order_code_vlid"></div>
								
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="customer_name">customer</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="customer_name" placeholder="customer name">
									</div>
								</div>
								<div id="customer_name_vlid"></div>
								
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="product_type">product type</label>
									</div>
									
									<div class="col-8">
										<select class="custom-select d-block w-100" id="product_type" required>
											
											<option value="cell">Cell</option>
											<option value="prp_ready">PRP Ready</option>
											<option value="placenta">Placenta</option>
										</select>
									</div>
								</div>
								<div id="product_type_vlid"></div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="quantity">quantity</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="quantity" placeholder="quantity">
									</div>
								</div>
								<div id="quantity_vlid"></div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="vial">vial</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="vial" placeholder="vial">
									</div>
								</div>
								<div id="vial_vlid"></div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="total_cel">total_cel</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="total_cel" placeholder="total of cel">
									</div>
								</div>
								<div id="total_cel_vlid"></div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="package_type">package</label>
									</div>
									
									<div class="col-8">
										<select class="custom-select d-block w-100" id="package_type" required>
											<option value="ID">ID</option>
											<option value="IV">IV</option>
											<option value="IV">IM</option>
										</select>
									</div>
								</div>
								<div id="package_vlid"></div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="delivery_date">delivery date</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="delivery_date" placeholder="date">
									</div>
								</div>
								<div id="delivery_date_vlid"></div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label>delivery time</label>
									</div>
									
									<div class="col-8">
										<div class="row">
											<div class="col-6">
												<select class="custom-select" id="delivery_time_hour" required>
													
													<?php 
														$h = 0;
														while ($h<=23) {

													?>
															<option value=<?php echo $h?>><?php echo $h ?></option>
													<?php 
															$h = $h+1;
														}

													?>
												</select>
											</div>
											<div class="col-6">
												<select class="custom-select" id="delivery_time_minute" required>
													<?php 
														$min = 0;
														while ($min<=59) {

													?>
															<option value=<?php echo $min?>><?php echo $min?></option>
													<?php 
															$min = $min+1;
														}

													?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div id="delivery_time_hour_vlid"></div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="giveaway">giveaway</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="giveaway" placeholder="giveaway">
									</div>
								</div>
								<div id="giveaway_vlid"></div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="sender">sender</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="sender" placeholder="sender">
									</div>
								</div>
								<div id="sender_vlid"></div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="receiver">receiver</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="receiver" placeholder="receiver">
									</div>
								</div>
								<div id="receiver_vlid"></div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="dealer_person">dealer_person</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="dealer_person" placeholder="dealer person">
									</div>
								</div>
								<div id="dealer_person_vlid"></div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="dealer_company">dealer_company</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="dealer_company" placeholder="dealer company">
									</div>
								</div>
								<div id="dealer_company_vlid"></div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="price_rate">price_rate</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="price_rate" placeholder="price rate">
									</div>
								</div>
								<div id="price_rate_vlid"></div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="comment_else">comment_else</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="comment_else" placeholder="comment">
									</div>
								</div>
								<div id="comment_else_vlid"></div>
							</div>
							<!-- **************************************** -->
							<hr class="mb-4">
							<button class="btn btn-primary btn-lg btn-block" id="bt_save_add_order" type="button" onclick="celtac.g_func.order('add_order')">Save</button>
							<input id="user_id_edit" type="hidden" value="">
							<!-- **************************************** -->
						  </form>
						  
						  
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					
				  </div>
				</div>
			  </div>
			</div>
		
		<!-- ************************************************************************************************************** -->
			<div class="modal fade" id="modal_delete_confirm" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true"   style="overflow-y: scroll">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<p class="modal-title" id="modalLabel">Confirmation.</p><!--  $('#exampleModalLabel').text("aaaaaaaaaaa"); -->
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body" id="modal-body-contact">
					<h3 style="color:red">warning.</h3>
					<p class="lead">Are you sure to delete this data?</p>
				  </div>
				  <div class="modal-footer">
					<button type="button" id="del_ok" class="btn btn-secondary" data-dismiss="modal">Ok</button>
					<button type="button" id="" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					
				  </div>
				</div>
			  </div>
			</div>
		<!-- ************************************************************************************************************** -->
			<div class="modal fade" id="loading_modal" tabindex="-1" role="dialog" aria-hidden="true"   style="overflow-y: scroll">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<p class="modal-title" id="modalLabel">info</p><!--  $('#exampleModalLabel').text("aaaaaaaaaaa"); -->
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body" id="modal-body-contact">
					<h3>waitting a minute.</h3>
					<p class="lead" id="msg_modal_notice_customer">
					<img class="irc_mi" src="image/loading.gif" alt="loading" width="50" height="50">
					</p>
				  </div>
				</div>
			  </div>
			</div>
		<!-- ************************************************************************************************************** -->
			<div class="modal fade" id="modal_notice_customer" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="false"   style="overflow-y: scroll">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<p class="modal-title" id="modalLabel">notice.</p><!--  $('#exampleModalLabel').text("aaaaaaaaaaa"); -->
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body" id="modal-body-contact">
					<h3 style="color:red">notice.</h3>
					<p class="lead" id="msg_modal_notice_customer">-</p>
				  </div>
				  <div class="modal-footer">
					<button type="button" id="" class="btn btn-secondary" data-dismiss="modal"> ok </button>
					
				  </div>
				</div>
			  </div>
			</div>
		<!-- ************************************************************************************************************** -->
		<main role="main" class="container">


		  <div>
				<!--
				<div class="row">
				<div class="col-3"><div style="color:#77797c">code</div></div>
				<div class="col-2"><div style="color:#77797c">customer</div></div>
				<div class="col-2"><div style="color:#77797c">product</div></div>
				<div class="col-4"><div style="color:#77797c">time</div></div>
				<div class="col-1"><div style="color:#77797c"></div></div>
				
				</div> 
				-->
				
<?php 
	$pre_code = '';
	//$swichted = false;
	$index_color = 0;
	foreach ($rs_arr as &$value) {

		if($pre_code != ''){
			
			if($value['order_code'] == $pre_code){
				if(($index_color%2)==0){
					$color = '#fcfcfc';
				} else {
					$color = '#c6c6c6';
				}
				$pre_code = $value['order_code'];
			}else{
				$index_color++;
				if($color == '#c6c6c6'){
					$color = '#fcfcfc';
				} else {
					$color = '#c6c6c6';
				}
				$pre_code = $value['order_code'];
			}
		} else {
			//--> init_config.
			$color = '#fcfcfc';
			$pre_code = $value['order_code'];
		}
?>
				
				<div class="row"  style="background-color:<?php echo $color; ?>">
					<div class="col-2"><div><?php echo $value['order_code']?></div></div>
					<div class="col-2"><div><?php echo $value['customer_name']?></div></div>
					<div class="col-2"><div><?php echo $value['product_type']?></div></div>
					<div class="col-4"><div><?php echo $value['delivery_date_time']?></div></div>
					<div class="col-1"><a href="#" onclick="celtac.g_func.order('view_order',<?php echo $value['id']?>)"><span class="ui-icon ui-icon-search"></span></p></a></div>
					<div class="col-1"><a href="#" onclick="celtac.g_func.order('delete_order',<?php echo $value['id']?>)"><span class="ui-icon ui-icon-trash"></span></p></a></div>
				</div>
				<hr class="mb-1">
				
<?php 
	}
?>

				<button class="btn my-2 my-sm-0" type="button" onclick="celtac.g_func.order('show_model_addorder')"><span class="ui-icon ui-icon-plus"></span></button>
				<button class="btn my-2 my-sm-0" type="button" onclick="celtac.g_func.order('send_mail')"><span class="ui-icon ui-icon-check"></span></button>
				
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