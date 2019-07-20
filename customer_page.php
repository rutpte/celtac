<?php
//--require dirname(__FILE__) . '/includes/init.inc.php';
require dirname(__FILE__) . '/includes/global_js_init.php';
 if (isset($_SESSION['email'])) {
	$obj 	= new Order($pdo);
	if ($_SESSION['is_staff']) {
		$rs_arr = $obj->getOrderStaff();
	} else {
		$rs_arr = $obj->getOrder();
	}
	
	//print_r($rs); exit;
	//print_r($val_data['name']);exit;
	
	 // echo '<pre>';
	// foreach ($rs_arr as &$val_data) {
		// print_r($val_data);
	// }
	// exit;
	//---------------------
	$data = array();
	if($rs_arr['success']){
		$data = $rs_arr['data'];
	}
	$arr_key = array();
	if($rs_arr['success']){
		foreach ($data as &$value) {
			$arr_key[$value['id']] = $value;
		}
	}

	
	// echo '<pre>';
	// print_r($arr_key);
	// exit;



?> 
<script>
//--> gobal variable in this page.
 var obj_all_order = <?php echo json_encode($arr_key) ?> 
 var items_product_arr = new Array();
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

	<body class="text-center rut_color">


		<!--- **************************** nav bar *************************************** -->
		<nav class="navbar navbar-expand-md navbar-dark bg-dark">
		  <a class="navbar-brand" href="#">HI : <?=$_SESSION['first_name']?></a>
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
			  <li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">menu</a>
				<div class="dropdown-menu bg-dark" aria-labelledby="dropdown01">
				  <a class="nav-link" style="color:#abadad" id="export_excel" href="#" onclick="celtac.g_func.modal_export('export_order')">export</a>
				  <a class="nav-link" style="color:#abadad" id="gen_qrcode" href="#" onclick="celtac.g_func.gen_qrcode()">generate QR code</a>
				  <?php if ($_SESSION['is_staff']) {?>
				  <a class="nav-link" style="color:#abadad" id="report_excel" href="#" onclick="celtac.g_func.modal_export('export_report')">report</a>
				  <a class="nav-link" style="color:#abadad" id="HEAT" href="/a4m_celtac" onclick="">HEAT</a>
				  <a class="nav-link" style="color:#abadad" id="celtic" href="/celtic" onclick="">Logistic</a>
				  <a class="nav-link" style="color:#abadad" id="celprograms" href="/programs/R-Oa.exe" onclick="">R-Oa</a>
				  <?php }?>
				</div>
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
										<label for="order_id_view">id</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="order_id_view" placeholder="">
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
										<label for="product_type_view">product</label>
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
										<input type="text" class="form-control" id="quantity_view" placeholder="">
									</div>
								</div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="set_view">set</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="set_view" placeholder="0">
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
										<input type="text" class="form-control" id="vial_view" placeholder="0">
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
										<input type="text" class="form-control" id="total_cel_view" placeholder="">
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
										<input type="text" class="form-control" id="package_type_view" placeholder="">
									</div>
								</div>
							</div>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="delivery_date_view">delivery</label>
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
							<hr class="mb-4"/>
							<!-- <button class="btn btn-primary btn-lg btn-block" id="bt_save_edit_order" type="button" onclick="celtac.g_func.order('edit_order',"+obj_all_order[25].id+")">Save</button> -->
							<!-- <div class="col-1"><a href="#" onclick="celtac.g_func.order('edit_order_model')"><span class="ui-icon ui-icon-pencil"></span></p></a></div> -->
							<button class="btn btn-lg btn-block" type="button" onclick="celtac.g_func.order('edit_order_model')"><span class="ui-icon ui-icon-pencil"></span></button>
							<input id="order_id_view" type="hidden" value=""/>
							<!--<input id="is_active_view" type="hidden" value=""/> not use.-->
						</form>
						<!-- end form -->
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div><!-- **main -->
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
							<!--<div>
								<div class="row">
									<div class="col-4">
										<label for="order_code_edit">order_code</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="order_code_edit" placeholder="CT-09/23">
									</div>
								</div>
								<div id="order_code_vlid_edit"></div>
								
							</div>-->
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
											<option value="prfm_set">PRFM SET</option>
											<option value="prfm_tuee">PRFM TUEE</option>
											<option value="gcsf">GCSF</option>
											<option value="hyagan">Hyagan</option>
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
										<label for="set_edit">set</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="set_edit" placeholder="set">
									</div>
								</div>
								<div id="vial_vlid"></div>
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
											<option value="IM">IM</option>
											<option value="IR">IR</option>
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

							<input id="order_id_edit" type="hidden" value="">
							
							<!-- ****************** show/hide check box ********************** -->
							<?php if(false){ /*if ($_SESSION['is_staff']) {*/?>
								<hr class="mb-4">
								<div class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" id="is_active_edit">
									<label class="custom-control-label" for="is_active_edit">to be active</label>
								</div>
							<?php } ?>
								
							<!-- **************************************** -->
							<hr class="mb-4">
							<button class="btn btn-primary btn-lg btn-block" id="bt_save_update_order"  type="button" onclick="celtac.g_func.order('edit_order')">update</button>
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
							<!--
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
							-->
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
							<div id="text_area_resizable">
								<div id="div_items_order">
									<!-- div for items product -->

								</div>

								<button class="btn my-2 my-sm-0" type="button" onclick="celtac.g_func.order('show_model_add_items_product')"><span class="ui-icon ui-icon-plus"></span></button>
								
							</div>
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
		<!-- model add items product -->
			<div class="modal fade" id="modal_add_items_product" tabindex="-1" role="dialog"  aria-hidden="true"  style="overflow-y: scroll">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title">add items product</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body" id="modal-body-add_items_product"   style="overflow-y: scroll">
						<form class="needs-validation" novalidate>
							<!-- **************************************** -->
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
											<option value="prfm_set">PRFM SET</option>
											<option value="prfm_tuee">PRFM TUEE</option>
											<option value="gcsf">GCSF</option>
											<option value="hyagan">Hyagan</option>
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
										<label for="set">set</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="set" placeholder="set">
									</div>
								</div>
								<div id="set_vlid"></div>
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
										<label for="total_cel">total_cell</label>
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
											<option value="IM">IM</option>
											<option value="IR">IR</option>
										</select>
									</div>
								</div>
								<div id="package_vlid"></div>
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
										<label for="price_rate">price_rate</label>
									</div>
									
									<div class="col-8">
										
										<select class="custom-select d-block w-100" id="price_rate" required>
											<option value="free">free</option>
											<option value="premium">premium</option>
											<option value="shareholder">shareholder</option>
											<option value="wholesale">wholesale</option>
											<option value="clinic">clinic</option>
										</select>
									</div>
								</div>
								<div id="price_rate_vlid"></div>
							</div>
							<!-- **************************************** -->
							<hr class="mb-4">
							<button class="btn btn-lg btn-block" id="bt_save_add_items_product" type="button" onclick="celtac.g_func.order('add_order_temp')">Add product</button>
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
		<div class="modal fade" id="modal_export" tabindex="-1" role="dialog"  aria-hidden="true"  style="overflow-y: scroll">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title">Export.</h5><!--  $('#exampleModalLabel').text("aaaaaaaaaaa"); -->
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body" id="modal-body-export"   style="overflow-y: scroll">
						<form class="needs-validation" novalidate>
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="exp_start_delivery_date">start</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="exp_start_delivery_date" placeholder="date">
									</div>
								</div>
								<div id="delivery_date_vlid"></div>
							</div>
							<!-- ********************************************************************************************* -->
							<div>
								<div class="row">
									<div class="col-4">
										<label>-</label>
									</div>
									
									<div class="col-8">
										<div class="row">
											<div class="col-6">
												<select class="custom-select" id="exp_start_delivery_time_hour" required>
													
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
												<select class="custom-select" id="exp_start_delivery_time_minute" required>
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
							<!-- *************************************************************************************************** -->
							<hr class="mb-4">
							<!-- *************************************************************************************************** -->
							<!-- **************************************** -->
							<div>
								<div class="row">
									<div class="col-4">
										<label for="exp_end_delivery_date">end</label>
									</div>
									
									<div class="col-8">
										<input type="text" class="form-control" id="exp_end_delivery_date" placeholder="date">
									</div>
								</div>
								<div id="delivery_date_vlid"></div>
							</div>
							<!-- ********************************************************************************************* -->
							<div>
								<div class="row">
									<div class="col-4">
										<label>-</label>
									</div>
									
									<div class="col-8">
										<div class="row">
											<div class="col-6">
												<select class="custom-select" id="exp_end_delivery_time_hour" required>
													
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
												<select class="custom-select" id="exp_end_delivery_time_minute" required>
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
							<!-- *************************************************************************************************** -->


						  </form>
						  
						  
				  </div>
				  <div class="modal-footer">
					<button class="btn btn-primary btn-lg btn-block" id="bt_export" type="button" onclick="">Export</button><!-- //celtac.g_func.export_excel() -->
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					
				  </div>
				</div>
			  </div>
			</div>
		
		<!-- ************************************************************************************************************** -->
		
			<div class="modal fade" id="modal_confirm" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true"   style="overflow-y: scroll">
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
					<p class="lead" id="msg_modal_notice_customer">-</p>
				  </div>
				  <div class="modal-footer">
					<button type="button" id="modal_confirm_ok" class="btn btn-secondary" data-dismiss="modal">Ok</button>
					<button type="button" id="" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					
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
					$color_deactive = "";
				/*
						$length = count($data);
						for ($x = 0; $x < $length; $x++) {
							//echo "The data is: {$data[$x]['is_active']} <br>";
							var_dump($data[$x]);
							echo "------------------------------------------";
						} 
						exit;
				*/
				/*
					//$data = [1,2,3,4,5,6,7,8,9,10];
					$length = count($data);
					//var_dump($length);exit;
					for ($x = 0; $x <$length; $x++) {
						//----------------------------
						//echo "nub".$x."| ";
						$value = $data[$x]['customer_name'];
						var_dump($value);
						//$value = $data[$x];
						//var_dump($value['customer_name']);
						//var_dump($value['is_active']);
					}
					exit;
				*/
				//----------------------------------
				$length = count($data);
				for ($x = 0; $x < $length; $x++) {
					//----------------------------
					//var_dump($x);
					$val_data = $data[$x];

					if($val_data['is_active']){
						$color_deactive = "";
						$icon_active = "ui-icon-unlocked";
					} else {
						//--> false.
						$color_deactive = "#9e3f45";
						$icon_active = "ui-icon-locked";
					}
					
					//----------------------------
					if($pre_code != ''){
						
						if($val_data['order_code'] == $pre_code){
							if(($index_color%2)==0){
								$color = '#fcfcfc';
							} else {
								$color = '#c6c6c6';
							}
							$pre_code = $val_data['order_code'];
						}else{
							$index_color++;
							if($color == '#c6c6c6'){
								$color = '#fcfcfc';
							} else {
								$color = '#c6c6c6';
							}
							$pre_code = $val_data['order_code'];
						}
					} else {
						//--> init_config.
						$color = '#fcfcfc';
						$pre_code = $val_data['order_code'];
					}
					?>
					
					<div class="row"  style="background-color:<?php echo $color; ?>">
						
						<div class="col-1 text-truncate font-weight-light" style="color:<?php echo $color_deactive; ?>"><div><?php echo $val_data['order_code']?></div></div>
						<div class="col-1 text-truncate font-weight-light" style="color:<?php echo $color_deactive; ?>"><div><?php echo $val_data['id']?></div></div>
						<div class="col-2 text-truncate font-weight-light" style="color:<?php echo $color_deactive; ?>"><div><?php echo $val_data['customer_name']?></div></div>
						<div class="col-2 text-truncate font-weight-light" style="color:<?php echo $color_deactive; ?>"><div><?php echo $val_data['product_type']?></div></div>
						<div class="col-3 text" style="color:<?php echo $color_deactive; ?>"><div><?php echo $val_data['delivery_date_time']?></div></div>
						<div class="col-1"><a href="#" onclick="celtac.g_func.order('view_order',<?php echo $val_data['id']?>)"><span style="margin:5px" class="ui-icon ui-icon-search"></span></p></a></div>
						<div class="col-1"><a href="#" onclick="celtac.g_func.order('delete_order',<?php echo $val_data['id']?>)"><span style="margin-top:5px" class="ui-icon ui-icon-trash"></span></p></a></div>
						<?php if ($_SESSION['is_staff']) {?>
							<div class="col-1"><a href="#" onclick="celtac.g_func.order('change_active',<?php echo $val_data['id']?>)"><span style="margin-top:5px" class="ui-icon <?php echo $icon_active; ?>"></span></p></a></div>
						<?php }?>
					</div>
					<hr class="mb-0">
				
				<?php 
					}
				?>

				<button class="btn my-2 my-sm-0" type="button" onclick="celtac.g_func.order('show_model_addorder')"><span class="ui-icon ui-icon-plus"></span></button>
				<button class="btn my-2 my-sm-0" type="button" onclick="celtac.g_func.order('update_order')"><span class="ui-icon ui-icon-check"></span></button>
				
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