<?php
	require dirname(__FILE__) . '/includes/init.inc.php';
	if (isset($_SESSION['email'])) {
		$obj 	= new Order($pdo);
		$rs_arr = $obj->getOrderAll();
		$data = array();
	
		if($rs_arr['success']){
			$data = $rs_arr['data'];
		}

	} else {
		header("Location: http://" . $_SERVER['HTTP_HOST'] ."/".PROJ_NAME. "/index.php");
	} 

	$Token = 'CxlMmXRcLg458GiyTx9kINPOKQjyLReSUnGLSyGdFwA';
	$message = isset($_POST["message"])? $_POST["message"] : 'help!' ;
	
	$str_msg = "";
	/*
	foreach ($data as &$value) {
		$obj_date 		= new DateTime($value['delivery_date_time']);;
		$daliv_date 	= $obj_date->format('d-m-Y');
		$daliv_time 	= $obj_date->format('H:i:s');
		
		$str_msg .= " daliv_date : ".$daliv_date." | ";
		$str_msg .= " daliv_time : ".$daliv_time." | ";
		$str_msg .= " order_code : ".$value['order_code']." | ";
		$str_msg .= " customer_name : ".$value['customer_name']." | ";
		$str_msg .= " product_type : ".$value['product_type']." | ";
		$str_msg .= " quantity : ".$value['quantity']." | ";
		$str_msg .= " vial : ".$value['vial']." | ";
		$str_msg .= " total_cel : ".$value['total_cel']." | ";
		$str_msg .= " package_type : ".$value['package_type']." | ";
		$str_msg .= " giveaway : ".$value['giveaway']." | ";
		$str_msg .= " sender : ".$value['sender']." | ";
		$str_msg .= " receiver : ".$value['receiver']." | ";
		$str_msg .= " dealer_person : ".$value['dealer_person']." | ";
		$str_msg .= " dealer_company : ".$value['dealer_company']." | ";
		$str_msg .= " price_rate : ".$value['price_rate']." | ";
		$str_msg .= " comment_else : ".$value['comment_else']." | ";
		
	}
	*/

	$message = $str_msg;
	//---------------------------------------

	function line_notify($Token, $message)
	{
		$lineapi = $Token; // ใส่ token key ที่ได้มา
		$mms =  trim($message); // ข้อความที่ต้องการส่ง
		date_default_timezone_set("Asia/Bangkok");
		$chOne = curl_init(); 
		curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
		// SSL USE 
		curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
		curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
		//POST 
		curl_setopt( $chOne, CURLOPT_POST, 1); 
		curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$mms"); 
		curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1); 
		$headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$lineapi.'', );
		curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
		curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
		$result = curl_exec( $chOne ); 
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
	line_notify($Token, $message);
