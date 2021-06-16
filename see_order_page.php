<?php
//--require dirname(__FILE__) . '/includes/init.inc.php';
require dirname(__FILE__) . '/includes/global_js_init.php';
$rs_permis 	= in_array("see_order_lab", $_SESSION['permissions']);
if($rs_permis){
	$obj 	= new Order($pdo);
	$rs_arr = $obj->getOrderAll();

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



	
	// echo '<pre>';
	// print_r($arr_key);
	// exit;

			
			
	//-----------------------------------------------------------------------------------------
	$tb_rut .='<table class="tg"';
		//$tb_rut .='<tr>';
		
			$tb_rut .='<thead>';
				$tb_rut .='<tr>';
					$tb_rut .='<th class="tg-0pky">delivery_date</th>';
					$tb_rut .='<th class="tg-0pky">delivery_time</th>';
					$tb_rut .='<th class="tg-0pky">order_code</th>';
					$tb_rut .='<th class="tg-0pky">id</th>';
					$tb_rut .='<th class="tg-0pky">customer</th>';
					$tb_rut .='<th class="tg-0pky">product</th>';
					$tb_rut .='<th class="tg-0pky">quantity</th>';
					$tb_rut .='<th class="tg-0pky">vial</th>';
					$tb_rut .='<th class="tg-0pky">total</th>';
					$tb_rut .='<th class="tg-0pky">package</th>';
					$tb_rut .='<th class="tg-0pky">giveaway</th>';
					$tb_rut .='<th class="tg-0pky">sender</th>';
					$tb_rut .='<th class="tg-0pky">receiver</th>';
					$tb_rut .='<th class="tg-0pky">dealer_person</th>';
					$tb_rut .='<th class="tg-0pky">dealer_company</th>';
					$tb_rut .='<th class="tg-0pky">price_rate</th>';
					$tb_rut .='<th class="tg-0pky">..........note..........</th>';
				$tb_rut .='</tr>';
			$tb_rut .='</thead>';
			$tb_rut .='<tbody>';
			
		//$tb_rut .='</tr>';
		//$tb_rut .='<tbody>';
		$pre_code = '';
		foreach ($data as &$value) {
			
			$obj_date 		= new DateTime($value['delivery_date_time']);
			$daliv_date 	= $obj_date->format('d-m-Y');
			$daliv_time 	= $obj_date->format('H:i:s');
			//-------------------------------------------
			if($pre_code != ''){
				
				if($daliv_date == $pre_code){
					if(($index_color%2)==0){
						$color = '#f4f2f2';
					} else {
						$color = '#ffffff';
					}
					$pre_code = $daliv_date;
				}else{
					$index_color++;
					if($color == '#ffffff'){
						$color = '#f4f2f2';
					} else {
						$color = '#ffffff';
					}
					$pre_code = $daliv_date;
				}
			} else {
				//--> init_config.
				$color = '#f4f2f2';
				$pre_code = $daliv_date;
			}
			//-------------------------------------------
			
				$tb_rut .='<tr>';
					$tb_rut .='<td class="tg" style="background-color:'.$color.'" id = "delivery_date">'.$daliv_date.'</td>';
					$tb_rut .='<td class="tg" style="background-color:'.$color.'" id = "delivery_time">'.$daliv_time.'</td>';
					$tb_rut .='<td class="tg" style="background-color:'.$color.'" id = "order_code">'.$value['order_code'].'</td>';
					$tb_rut .='<td class="tg" style="background-color:'.$color.'" id = "id">'.$value['id'].'</td>';
					$tb_rut .='<td class="tg" style="background-color:'.$color.'" id = "customer_name">'.$value['customer_name'].'</td>';
					$tb_rut .='<td class="tg" style="background-color:'.$color.'" id = "product_type">'.$value['product_type'].'</td>';
					$tb_rut .='<td class="tg" style="background-color:'.$color.'" id = "quantity">'.$value['quantity'].'</td>';
					$tb_rut .='<td class="tg" style="background-color:'.$color.'" id = "vial">'.$value['vial'].'</td>';
					$tb_rut .='<td class="tg" style="background-color:'.$color.'" id = "total_cel">'.$value['total_cell'].'</td>';
					$tb_rut .='<td class="tg" style="background-color:'.$color.'" id = "package_type">'.$value['package_type'].'</td>';
					$tb_rut .='<td class="tg" style="background-color:'.$color.'" id = "giveaway">'.$value['giveaway'].'</td>';
					$tb_rut .='<td class="tg" style="background-color:'.$color.'" id = "sender">'.$value['sender'].'</td>';
					$tb_rut .='<td class="tg" style="background-color:'.$color.'" id = "receiver">'.$value['receiver'].'</td>';
					$tb_rut .='<td class="tg" style="background-color:'.$color.'" id = "dealer_person">'.$value['dealer_person'].'</td>';
					$tb_rut .='<td class="tg" style="background-color:'.$color.'" id = "dealer_company">'.$value['dealer_company'].'</td>';
					$tb_rut .='<td class="tg" style="background-color:'.$color.'" id = "price_rate">'.$value['price_rate'].'</td>';
					$tb_rut .='<td class="tg" style="background-color:'.$color.'" id = "comment_else">'.$value['comment_else'].'</td>';
				$tb_rut .='</tr>';
			
		}//end loop tr value.
		$tb_rut .='</tbody>';

		//$tb_rut .='</tbody>';
	$tb_rut .='</table>';
	//-----------------------------------------------------------------------------------------

?> 


<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="apple-touch-icon" href='logo.jpg'>
		<link rel="icon" href="logo.jpg">

		<title>celtac order</title>
	
		<style type="text/css">
		.tg  {border-collapse:collapse;border-color:#93a1a1;border-spacing:0;}
		.tg td{background-color:#fdf6e3;border-color:#93a1a1;border-style:solid;border-width:1px;color:#002b36;
		  font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;word-break:normal;}
		.tg th{background-color:#657b83;border-color:#93a1a1;border-style:solid;border-width:1px;color:#fdf6e3;
		  font-family:Arial, sans-serif;font-size:14px;font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
		.tg .tg-2bhk{background-color:#eee8d5;border-color:inherit;text-align:left;vertical-align:top}
		.tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
		
		.el_center {
		  
		  margin: auto;
		  background-color: #635e4e;
		  margin-top: 10px;
		  margin-left: 10px;
		}
		</style>


	</head>
	<body class ="el_center">
	
	
	
	
	
		<div>

			<?php echo $tb_rut; ?>
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