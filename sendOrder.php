<?php
require dirname(__FILE__) . '/includes/init.inc.php';
//header('Content-Type: text/html; charset=utf-8');
 if (isset($_SESSION['email'])) {
	$obj 	= new Order($pdo);
	$rs_arr = $obj->getOrderAll();
	$data = array();
	if($rs_arr['success']){
		$data = $rs_arr['data'];
	}
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
$from_email_pass  	= 'celtac1234';
//$mailTo 			= array("yupa.pangtum@gmail.com", "thongjet@hotmail.com", "my_name_is_ken@live.com", "iloveubon@gmail.com", "zerokung.devil@gmail.com");
$mailTo 			= array("zerokung.devil@gmail.com", "iloveubon@gmail.com");


//-----------------------------------------------------------------------------------------
$tb_rut .='<table class="table"';
	$tb_rut .='<thead>';
		$tb_rut .='<tr>';
			$tb_rut .='<th>delivery_date</th>';
			$tb_rut .='<th>delivery_time</th>';
			$tb_rut .='<th>order_code</th>';
			$tb_rut .='<th>customer</th>';
			$tb_rut .='<th>product</th>';
			$tb_rut .='<th>quantity</th>';
			$tb_rut .='<th>vial</th>';
			$tb_rut .='<th>total</th>';
			$tb_rut .='<th>package</th>';
			$tb_rut .='<th>giveaway</th>';
			$tb_rut .='<th>sender</th>';
			$tb_rut .='<th>receiver</th>';
			$tb_rut .='<th>dealer_person</th>';
			$tb_rut .='<th>dealer_company</th>';
			$tb_rut .='<th>price_rate</th>';
			$tb_rut .='<th>..........note..........</th>';
		$tb_rut .='</tr>';
	$tb_rut .='</thead>';
	$tb_rut .='<tbody>';
	foreach ($data as &$value) {
		
		$obj_date 		= new DateTime($value['delivery_date_time']);;
		$daliv_date 	= $obj_date->format('d-m-Y');
		$daliv_time 	= $obj_date->format('H:i:s');
		
		
		$tb_rut .='<tr>';
			$tb_rut .='<td id = "delivery_date">'.$daliv_date.'</td>';
			$tb_rut .='<td id = "delivery_time">'.$daliv_time.'</td>';
			$tb_rut .='<td id = "order_code">'.$value['order_code'].'</td>';
			$tb_rut .='<td id = "customer_name">'.$value['customer_name'].'</td>';
			$tb_rut .='<td id = "product_type">'.$value['product_type'].'</td>';
			$tb_rut .='<td id = "quantity">'.$value['quantity'].'</td>';
			$tb_rut .='<td id = "vial">'.$value['vial'].'</td>';
			$tb_rut .='<td id = "total_cel">'.$value['total_cel'].'</td>';
			$tb_rut .='<td id = "package_type">'.$value['package_type'].'</td>';
			$tb_rut .='<td id = "giveaway">'.$value['giveaway'].'</td>';
			$tb_rut .='<td id = "sender">'.$value['sender'].'</td>';
			$tb_rut .='<td id = "receiver">'.$value['receiver'].'</td>';
			$tb_rut .='<td id = "dealer_person">'.$value['dealer_person'].'</td>';
			$tb_rut .='<td id = "dealer_company">'.$value['dealer_company'].'</td>';
			$tb_rut .='<td id = "price_rate">'.$value['price_rate'].'</td>';
			$tb_rut .='<td id = "comment_else">'.$value['comment_else'].'</td>';

		$tb_rut .='</tr>';
	}

	$tb_rut .='</tbody>';
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
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to//587
		
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

    $mail->send();
	//--> it will return many text.
    // $result["success"] = true;
	// echo json_encode($result);
	// exit;
} catch (Exception $e) {
	$result["success"] = false;
	echo json_encode($result);
}