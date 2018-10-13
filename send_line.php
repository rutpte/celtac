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
	
	
	
	foreach ($data as &$value) {
		$str_msg = "";
		$obj_date 		= new DateTime($value['delivery_date_time']);;
		$daliv_date 	= $obj_date->format('d-m-Y');
		$daliv_time 	= $obj_date->format('H:i:s');
		
		$str_msg .= "  ".$daliv_date." ";
		$str_msg .= ", ".$daliv_time."\n";
		$str_msg .= " รหัสสั่งซื้อ  : ".$value['order_code']." ";
		$str_msg .= " ชื่อลูกค้า  : ".$value['customer_name']."\n";
		$str_msg .= " ชนิดสินค้า : ".$value['product_type']." ";
		
		if($value['product_type'] == "cell"){
			$str_msg .= " จำนวน cell : ".$value['quantity']." ล้าน\n";
			$str_msg .= " จำนวนหลอด : ".$value['vial']."\n";
			$str_msg .= " cell ทั้งหมด : ".$value['total_cel']." ล้าน\n";
			$str_msg .= " ประเภทใช้งาน  : ".$value['package_type']."\n";
		} else {
			$str_msg .= " จำนวนหลอด : ".$value['vial']."\n";
		}

		$str_msg .= " ของแถม  : ".$value['giveaway']."\n";
		$str_msg .= " ผู้ส่ง  : ".$value['sender']." ";
		$str_msg .= " ผู้รับ  : ".$value['receiver']."\n";
		$str_msg .= " ผู้ติดต่อ : ".$value['dealer_person']." ";
		$str_msg .= " ขายผ่าน  : ".$value['dealer_company']."\n";
		$str_msg .= " ประเภทราคา : ".$value['price_rate']." ";
		$str_msg .= " อื่นๆ : ".$value['comment_else']."\n";
		//$str_msg .= " *----* \n";
		
		$str_msg .= " ****  ผู้ส่ง  : ".$value['sender']."\n";
		
		//$str_msg .= " *----* \n";

		$str_msg .= "http://163.44.196.239/celtac/excel_output/order_cell.xls";
		$str_msg .= "\n\n\n";
		
		//--> send line.
		$message = $str_msg;
		line_notify($Token, $message);
	}
	

	
	//---------------------------------------
	//'./excel_output/order_cell.xls'
	function line_notify_bc($Token, $message)
	{
		//--$file_name_with_full_path = realpath('./excel_output/order_cell.xls');
		$fp = fopen ('./excel_output/order_cell.xls', 'w+');
		//$file = CURLFile(realpath($file_name_with_full_path));
		// if (function_exists('curl_file_create')) { // php 5.5+
		  // $cFile = curl_file_create($file_name_with_full_path);
		// } else { // 
		  // $cFile = '@' . realpath($file_name_with_full_path);
		// }
		//$post = array('extra_info' => '123456','file_contents'=> $cFile);
		//-----------------------------------------------------
		$message_data = array(
			//'extra_info' => '123456',
			//'file_contents'=>'@'.$file_name_with_full_path,
			'message' => $message,
			//'imageFile' => ,
			'stickerPackageId' =>1,
			'stickerId' =>106
			//--> https://devdocs.line.me/files/sticker_list.pdf
		);
		$http_data = http_build_query($message_data);
		$lineapi = $Token; // ใส่ token key ที่ได้มา
		//--$mms =  trim($message); // ข้อความที่ต้องการส่ง
		date_default_timezone_set("Asia/Bangkok");
		
		
		//--------------------------------------------------------------------------
		
		$chOne = curl_init(); 
		curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
		// SSL USE 
		curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
		curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
		//POST 
		curl_setopt( $chOne, CURLOPT_POST, 1); 
		//curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message_data); 
		//curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$mms); 
		curl_setopt( $chOne, CURLOPT_POSTFIELDS, $http_data); 
		curl_setopt($chOne, CURLOPT_FILE, $fp); 
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
	
	//--------------------------------------------------------------------------
	if(false){
		define('LINE_API',"https://notify-api.line.me/api/notify");
		$token = $Token; //ใส่Token ที่copy เอาไว้
		$str = $message; //ข้อความที่ต้องการส่ง สูงสุด 1000 ตัวอักษร
		$stickerPkg = 1; //stickerPackageId
		$stickerId = 106; //stickerId
		//$file_name_with_full_path = realpath('./excel_output/order_cell.xls');
		
		function notify_message($message,$stickerPkg,$stickerId,$token){
			 $queryData = array(
				'file_contents'=>'@'.$file,
				'message' => $message,
				'stickerPackageId'=>$stickerPkg,
				'stickerId'=>$stickerId
			 );
			 $queryData = http_build_query($queryData,'','&');
			 $headerOptions = array(
				 'http'=>array(
					 'method'=>'POST',
					 'header'=> "Content-Type: application/x-www-form-urlencoded\r\n"
						 ."Authorization: Bearer ".$token."\r\n"
							   ."Content-Length: ".strlen($queryData)."\r\n",
					 'content' => $queryData
				 ),
			 );
			 $context = stream_context_create($headerOptions);
			 $result = file_get_contents(LINE_API,FALSE,$context);
			 $res = json_decode($result);
		  return $res;
		 }
		//--------------------------------------------------------------------------
			 
		//$res = notify_message($str,$stickerPkg,$stickerId,$token);
		//print_r($res);
	}

	