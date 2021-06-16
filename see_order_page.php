<?php
//--require dirname(__FILE__) . '/includes/init.inc.php';
require dirname(__FILE__) . '/includes/global_js_init.php';
$rs_permis 	= in_array("see_order_lab", $_SESSION['permissions']);
if($rs_permis){
	$obj 	= new Order($pdo);
	$rs_arr = $obj->getOrderStaff();

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
		$arr_key = array();
		foreach ($data as &$value) {
			$arr_key[$value['id']] = $value;
		}
	}



	
	echo '<pre>';
	print_r($arr_key);
	exit;



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
		<link href="css/css.css" rel="stylesheet">
		
		<style type="text/css">
		.tg  {border-collapse:collapse;border-color:#93a1a1;border-spacing:0;}
		.tg td{background-color:#fdf6e3;border-color:#93a1a1;border-style:solid;border-width:1px;color:#002b36;
		  font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;word-break:normal;}
		.tg th{background-color:#657b83;border-color:#93a1a1;border-style:solid;border-width:1px;color:#fdf6e3;
		  font-family:Arial, sans-serif;font-size:14px;font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
		.tg .tg-2bhk{background-color:#eee8d5;border-color:inherit;text-align:left;vertical-align:top}
		.tg .tg-c3ow{border-color:inherit;text-align:center;vertical-align:top}
		.tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
		
		.el_center {
		  max-width: 500px;
		  margin: auto;
		  background-color: #635e4e;
		  margin-top: 10px;
		}
		</style>


	</head>
	<body class ="el_center">
		<div>

			<table class="tg">
			<thead>
			  <tr>
				<th class="tg-c3ow">dfdfd</th>
				<th class="tg-0pky">dfdfd</th>
				<th class="tg-0pky">dfdf</th>
				<th class="tg-0pky">dfdfdfd</th>
				<th class="tg-0pky">dfdfdfdf</th>
				<th class="tg-0pky">dfdfdfd</th>
				<th class="tg-0pky">dfdfdf</th>
				<th class="tg-0pky">dfdfdf</th>
				<th class="tg-0pky">dfdfdfd</th>
			  </tr>
			</thead>
			<tbody>
			  <tr>
				<td class="tg-2bhk">erere</td>
				<td class="tg-2bhk">ererer</td>
				<td class="tg-2bhk">ererer</td>
				<td class="tg-2bhk">erer</td>
				<td class="tg-2bhk">erer</td>
				<td class="tg-2bhk">ere</td>
				<td class="tg-2bhk">er</td>
				<td class="tg-2bhk">er</td>
				<td class="tg-2bhk">er</td>
			  </tr>
			  <tr>
				<td class="tg-0pky">erer</td>
				<td class="tg-0pky">erer</td>
				<td class="tg-0pky">erer</td>
				<td class="tg-0pky">erer</td>
				<td class="tg-0pky">erer</td>
				<td class="tg-0pky">rer</td>
				<td class="tg-0pky">er</td>
				<td class="tg-0pky">er</td>
				<td class="tg-0pky">er</td>
			  </tr>
			  <tr>
				<td class="tg-2bhk">erer</td>
				<td class="tg-2bhk">erer</td>
				<td class="tg-2bhk">erer</td>
				<td class="tg-2bhk">erer</td>
				<td class="tg-2bhk">erer</td>
				<td class="tg-2bhk">erer</td>
				<td class="tg-2bhk">ere</td>
				<td class="tg-2bhk">ere</td>
				<td class="tg-2bhk">er</td>
			  </tr>
			</tbody>
			</table>
		</div>
		<!--<script type='text/javascript' src='js/js_index_src.js'></script>-->
		<script>
			
			//------------------------------------------------------------------------------------------------
			$( document ).ready(function() {
				console.log( "ready admin page!" );
			});
			
			
		</script>
	</body>
</html>
 <?php } else {
		
		header("Location: http://" . $_SERVER['HTTP_HOST'] ."/".PROJ_NAME. "/index.php");
	} 

?>