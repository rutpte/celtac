<?php
	require dirname(__FILE__) . '/includes/init.inc.php';
	if (isset($_SESSION['email'])) {
		/* stand by
		$obj 	= new Order($pdo);
		$rs_arr = $obj->getOrderAll();
		$data = array();
	
		if($rs_arr['success']){
			$data = $rs_arr['data'];
		}
		*/

	} else {
		header("Location: http://" . $_SERVER['HTTP_HOST'] ."/".PROJ_NAME. "/index.php");
	} 

	$Token = 'n6CCafOSXXpteZoJbffm3dKPxhcU9H8rxt583aYrqmQ';
	$message = isset($_POST["message"])? $_POST["message"] : 'help!' ;
	//--------------------------------------------
	function line_notify($Token, $message)
	{
		//$msg = $message ."'http://163.44.196.239/celtac/excel_output/order_cell.xls'";
		//-----------------------------------------------------
		$message_data = array(
			'message' => $message
			,'stickerPackageId' =>1
			,'stickerId' =>106
			//--> https://devdocs.line.me/files/sticker_list.pdf
		);
		$http_data = http_build_query($message_data);
		$lineapi = $Token;
		date_default_timezone_set("Asia/Bangkok");

		//--------------------------------------------------------------------------
		
		$chOne = curl_init(); 
		curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
		// SSL USE 
		curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
		curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
		//POST 
		curl_setopt( $chOne, CURLOPT_POST, 1); 
		curl_setopt( $chOne, CURLOPT_POSTFIELDS, $http_data); 
		curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1); 
		$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$lineapi.'', );
		curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
		curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
		$result = curl_exec( $chOne ); 
		
		//-------------------------------------------------------------------------
		//Check error 
		if(curl_error($chOne)){ 
		   echo 'error:' . curl_error($chOne); 
		   
		} else { 
		$result_ = json_decode($result, true); 
		   echo "status : ".$result_['status']; echo "message : ". $result_['message'];
		} 
		curl_close( $chOne );   
	}
	//--------------------------------------------
		$message .= "\n http://163.44.196.239/celtac/excel_output/order_cell.xls";
		line_notify($Token, $message);
	//---------------------------------------------------------------------------------------------------------------
	/* stand by
	foreach ($data as &$value) {
		$str_msg = "";
		$obj_date 		= new DateTime($value['delivery_date_time']);;
		$daliv_date 	= $obj_date->format('d-m-Y');
		$daliv_time 	= $obj_date->format('H:i:s');
		
		$str_msg .= $value['order_code']." \n\n ";
		
		$str_msg .= "  ".$daliv_date." ";
		$str_msg .= ", ".$daliv_time."\n";
		
		$str_msg .= " ชื่อลูกค้า  : ".$value['customer_name']."\n";
		//$str_msg .= " ชนิดสินค้า : ".$value['product_type']." ";
		
		if($value['product_type'] == "cell"){
			$str_msg .= $value['product_type'].' '.$value['quantity']." ล้าน  ";
			$str_msg .= $value['vial']." หลอด ";

			$str_msg .= $value['package_type']."\n";
		} else {
			$str_msg .= $value['product_type'].' '." ".$value['vial']." หลอด\n";
		}

		$str_msg .= $value['giveaway']."\n";
		//$str_msg .= " ผู้ส่ง  : ".$value['sender']." ";
		//$str_msg .= " ผู้รับ  : ".$value['receiver']."\n";
		//$str_msg .= " ผู้ติดต่อ : ".$value['dealer_person']." ";
		//$str_msg .= " ขายผ่าน  : ".$value['dealer_company']."\n";
		//$str_msg .= " ประเภทราคา : ".$value['price_rate']." ";
		$str_msg .= " อื่นๆ : ".$value['comment_else']."\n";
		//$str_msg .= " *----* \n";
		
		$str_msg .= " ****  ผู้ส่ง  : ".$value['sender']."\n";
		
		//$str_msg .= " *----* \n";

		//$str_msg .= "http://163.44.196.239/celtac/excel_output/order_cell.xls";
		$str_msg .= "\n\n\n";
		
		//--> send line.
		$message = $str_msg;
		line_notify($Token, $message);
	}
	*/
	//---------------------------------------------------------------------------------------------------------------




	
