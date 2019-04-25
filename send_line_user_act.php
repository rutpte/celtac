<?php
	require dirname(__FILE__) . '/includes/init.inc.php';
	if (isset($_SESSION['email'])) {
		//stand by
	} else {
		header("Location: http://" . $_SERVER['HTTP_HOST'] ."/".PROJ_NAME. "/index.php");
		exit();
	} 

	$Token = 'tzhMBh8NPaLFOUwJIWTSeHnYS1bMZJAL5rr0ejf6yPZ';
	$message = isset($_POST["message"])? $_POST["message"] : 'help!' ;
	$act_type_process 	= isset($_POST["act_type_process"])? $_POST["act_type_process"] : 0 ;
	$act_id 			= isset($_POST["act_id"])? $_POST["act_id"] : 0 ;
	//------------------------------------------
	$obj 	= new Order($pdo);
	$rs_arr = $obj->getOrderAct($act_type_process, $act_id);
	$data = array();

	if($rs_arr['success']){
		$data = $rs_arr['data'];
	}
	$obj->doLog("sendLine start - ".$_SESSION['email']);
	//--------------------------------------------
	
	function line_notify($Token, $message)
	{
		$obj 	= new Order($pdo);
		//$msg = $message ."'http://163.44.196.239/celtac/excel_output/order_cell.xls'";
		//-----------------------------------------------------
		$message_data = array(
			'message' => $message
			//,'stickerPackageId' =>1
			//,'stickerId' =>106
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
		   $obj->doLog("sendLine error - ".$_SESSION['email']." : ".curl_error($chOne));
		} else {
		$result_ = json_decode($result, true); 
			$obj->doLog("sendLine success - ".$_SESSION['email']);
		   echo "status : ".$result_['status']; echo "message : ". $result_['message'];
		} 
		curl_close( $chOne );   
	}
	$obj->doLog("sendLine complete - ".$_SESSION['email']);
	//--------------------------------------------
	$arr_message = array();
	$message .= "******************\n";
	$message .= "action : ".$act_type_process."\n";
	$message .=" user  : ";
	$message .= isset($_SESSION['first_name'])? $_SESSION['first_name']."\n" : 'auto update'."\n"; 
	$chk_mod = 0;
	foreach ($data as &$value) {
		$str_msg = "\n";
		$obj_date 		= new DateTime($value['delivery_date_time']);;
		$daliv_date 	= $obj_date->format('d-m-Y');
		$daliv_time 	= $obj_date->format('H:i');
		
		//--$str_msg .= $value['order_code']." \n\n ";
		
		$str_msg .= "*  ".$daliv_date." ";
		$str_msg .= ", ".$daliv_time." ";
		
		$str_msg .= " : ".$value['customer_name']." ";
		//$str_msg .= " ชนิดสินค้า : ".$value['product_type']." ";
		
		//--------------------------
		$set = 0;
		$vial = 0;
		if($value['set'] !== NULL) {
			$set = $value['set'];
		}
		if($value['vial'] !== NULL) {
			$vial = $value['vial'];
		}
		
		if($value['product_type'] == "cell"){
			$str_msg .= $value['product_type'].' '.$value['quantity']." m ";
			$str_msg .= $vial." vial ";

			$str_msg .= $value['package_type']." ";
		} else if ($value['product_type'] == "hyagan" || $value['product_type'] == "gcsf"){
			$str_msg .= $value['product_type'].' '.$value['quantity']." box ";
		} else if ($value['product_type'] == "prfm_set"){
			$str_msg .= $value['product_type'].' '.$value['quantity']." set ";
		} else {
			$str_msg .= $value['product_type'].' '." ";
			//--$str_msg .= $set." set ";
			$str_msg .= $vial." vial ";
		}

		$str_msg .= "  ผู้ส่ง  : ".$value['sender']."\n";
		
		//$str_msg .= " *----* \n";

		//$str_msg .= "http://163.44.196.239/celtac/excel_output/order_cell.xls";
		$str_msg .= " ";
		
		//--> send line.
		$message .= $str_msg;
		//--line_notify($Token, $message);
		$chk_mod++;
		if(($chk_mod % 10) == 0){
			array_push($arr_message,$message);
			$message = "";
		}
	}
	//-> push remain message.
	if($message != ""){
		array_push($arr_message,$message);
	}
	
	
	foreach ($arr_message as &$value) {
		line_notify($Token, $value);
	}
