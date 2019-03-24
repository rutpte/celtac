<?php
require dirname(__FILE__) . '/includes/init.inc.php';
//header('Content-Type: text/html; charset=utf-8');

$obj 	= new Order($pdo);
 if (isset($_SESSION['email'])) {
	
	$rs_arr = $obj->getOrderAll();
	$data = array();
	if($rs_arr['success']){
		$data = $rs_arr['data'];
	}
	$obj->doLog("sendmail start - ".$_SESSION['email']);
	// var_dump($rs_arr);
	// foreach ($rs_arr as &$value) {
		// echo $value['id'];
		// echo $value['order_code'];
		// echo ' | ';
	// }
	// exit;
} else {
	header("Location: http://" . $_SERVER['HTTP_HOST'] ."/".PROJ_NAME. "/index.php");
} 
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'libs/PHPMailer/src/Exception.php';
require 'libs/PHPMailer/src/PHPMailer.php';
require 'libs/PHPMailer/src/SMTP.php';
//Load Composer's autoloader
//require 'vendor/autoload.php';

//--> instance class.
//--> call method sum order and get data.
//--> loop data for create content html and set it to $html_mail.

$from_email 		= 'celtac.order@gmail.com';
$from_email_pass  	= '';
$mailTo = array(
"sopidakolahol@gmail.com"
 ,"chaivanida@gmail.com" 
 , "yupa.pangtum@gmail.com" 
 , "thongjet@hotmail.com" 
 , "thawee2507@hotmail.com" 
 , "rsubkk@hotmail.com" 
 , "my_name_is_ken@live.com" 
 , "celtac@live.com" 
 , "apichat_99_pk_@hotmail.com"
 , "iloveubon@gmail.com"

	//, "zerokung.devil@gmail.com"
);
//$mailTo 			= array("zerokung.devil@gmail.com", "iloveubon@gmail.com");


//-----------------------------------------------------------------------------------------
$tb_rut .='<table class="table"';
	//$tb_rut .='<tr>';
	
		$tb_rut .='<tr>';
			$tb_rut .='<td>delivery_date</td>';
			$tb_rut .='<td>delivery_time</td>';
			$tb_rut .='<td>order_code</td>';
			$tb_rut .='<td>id</td>';
			$tb_rut .='<td>customer</td>';
			$tb_rut .='<td>product</td>';
			$tb_rut .='<td>quantity</td>';
			$tb_rut .='<td>vial</td>';
			$tb_rut .='<td>total</td>';
			$tb_rut .='<td>package</td>';
			$tb_rut .='<td>giveaway</td>';
			$tb_rut .='<td>sender</td>';
			$tb_rut .='<td>receiver</td>';
			$tb_rut .='<td>dealer_person</td>';
			$tb_rut .='<td>dealer_company</td>';
			$tb_rut .='<td>price_rate</td>';
			$tb_rut .='<td>..........note..........</td>';
		$tb_rut .='</tr>';
		
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
			$tb_rut .='<td style="background-color:'.$color.'" id = "delivery_date">'.$daliv_date.'</td>';
			$tb_rut .='<td style="background-color:'.$color.'" id = "delivery_time">'.$daliv_time.'</td>';
			$tb_rut .='<td style="background-color:'.$color.'" id = "order_code">'.$value['order_code'].'</td>';
			$tb_rut .='<td style="background-color:'.$color.'" id = "id">'.$value['id'].'</td>';
			$tb_rut .='<td style="background-color:'.$color.'" id = "customer_name">'.$value['customer_name'].'</td>';
			$tb_rut .='<td style="background-color:'.$color.'" id = "product_type">'.$value['product_type'].'</td>';
			$tb_rut .='<td style="background-color:'.$color.'" id = "quantity">'.$value['quantity'].'</td>';
			$tb_rut .='<td style="background-color:'.$color.'" id = "vial">'.$value['vial'].'</td>';
			$tb_rut .='<td style="background-color:'.$color.'" id = "total_cel">'.$value['total_cell'].'</td>';
			$tb_rut .='<td style="background-color:'.$color.'" id = "package_type">'.$value['package_type'].'</td>';
			$tb_rut .='<td style="background-color:'.$color.'" id = "giveaway">'.$value['giveaway'].'</td>';
			$tb_rut .='<td style="background-color:'.$color.'" id = "sender">'.$value['sender'].'</td>';
			$tb_rut .='<td style="background-color:'.$color.'" id = "receiver">'.$value['receiver'].'</td>';
			$tb_rut .='<td style="background-color:'.$color.'" id = "dealer_person">'.$value['dealer_person'].'</td>';
			$tb_rut .='<td style="background-color:'.$color.'" id = "dealer_company">'.$value['dealer_company'].'</td>';
			$tb_rut .='<td style="background-color:'.$color.'" id = "price_rate">'.$value['price_rate'].'</td>';
			$tb_rut .='<td style="background-color:'.$color.'" id = "comment_else">'.$value['comment_else'].'</td>';

		$tb_rut .='</tr>';
	}

	//$tb_rut .='</tbody>';
$tb_rut .='</table>';
//-----------------------------------------------------------------------------------------
$new_tb="";
$new_tb .='<html>';
$new_tb .='   <head>';
$new_tb .='		<meta charset="tis-620">';
$new_tb .='      <style>';
$new_tb .=' 
		h2 {
		  text-align: left;
		  padding: 10px 0;
		  color:#878787;
		}

		.table-bordered {
			border: 1px solid #a7a8aa !important;
			border-collapse: collapse;
			border-spacing: 10px;   
		}
		table th {
			color:#595959;
			background-color: #e5e6e8;
			border-style: double;
			border-color: #ccccce;
		}
		table td {
			border: 1px solid #a7a8aa !important;
			border-radius: 1px;
			color : #878787;
		}
		@media screen and (max-width: 767px) {
		  table caption {
			display: none;
		  }
		}

		.p {
		  text-align: center;
		  padding-top: 140px;
		  font-size: 14px;
		}
	';
$new_tb .='      </style>';
$new_tb .='   </head>';
$new_tb .='   <body>';
$new_tb .='   <h2> Hi Celtac laboratory team, you have new order cell or new update ,check your new order here.</br></h2>';
//----------------------------------------------------------
$new_tb .= $tb_rut;
//----------------------------------------------------------
//$message = "</br></hr> <a href='http://163.44.196.239/celtac/excel_output/order_cell.xls'> check original excel file.</a>";
$new_tb .= $message;
//----------------------------------------------------------
$new_tb .='   </body>';
$new_tb .='</html>';



$html_mail = $new_tb;
// echo $new_tb;
// exit;
//-----------------------------------------------------------------------------------------
$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
	$mail->CharSet = 'UTF-8';
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  					  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = $from_email;                 // SMTP username
    $mail->Password = $from_email_pass;                           // SMTP password
    //$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted//tls
    //$mail->Port = 587;   
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted//tls
    $mail->Port = 465; 
	// TCP port to connect to//587
	//$mail->SMTPAuth = false;
	//$mail->SMTPSecure = false;
		
	$obj_date 		= new DateTime();
	$timezone 		= new DateTimeZone("Asia/Bangkok");
	$obj_date->setTimezone( $timezone );
	$date_formated 	= $obj_date->format('Y-m-d H:i:s');
	//echo $date_formated; exit;
    //Recipients
    $mail->setFrom('celtac.order@gmail.com', 'Order-Cell : '.$date_formated.'.');
	
	//--> loop add mail.Add a recipient
	
	foreach ($mailTo as &$value) {
		$mail->addAddress($value, $value);
	}
   
    //$mail->addAddress('ellen@example.com');               // Name is optional
    //$mail->addReplyTo('pte.engineer@gmail.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $date_formated;
    $mail->Body    = $html_mail;
    $mail->AltBody = 'Order-Cell3';
	$mail->AddAttachment('excel_output/order_cell.xls', "order.xls");
    $mail->send();
	//--> it will return many text.
    // $result["success"] = true;
	// echo json_encode($result);
	// exit;
} catch (Exception $e) {
	//write log.
	$msg = "can not send order : ".$e;
	$obj->write_log($msg);
	$result["success"] = false;
	echo json_encode($result);
}