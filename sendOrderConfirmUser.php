<?php
require dirname(__FILE__) . '/includes/init.inc.php';
 if (isset($_SESSION['email'])) {

	$obj 	= new Order($pdo);
	$rs_arr = $obj->getOrder();
	$data = array();
	if($rs_arr['success']){
		$data = $rs_arr['data'];
	}
	// foreach ($rs_arr as &$value) {
		// echo $value;
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
//$mailTo 			= array("yupa.pangtum@gmail.com", "thongjet@hotmail.com", "my_name_is_ken@live.com", "iloveubon@gmail.com", "zerokung_2011@hotmail.com");
$mailTo 			= array($_SESSION['email']);

//-----------------------------------------------------------------------------------------

$tb_rut .='<table class="table table-bordered table-hover"';
	$tb_rut .='<thead>';
		$tb_rut .='<tr>';
			$tb_rut .='<th>delivery</th>';
			$tb_rut .='<th>order code</th>';
			$tb_rut .='<th>customer</th>';
			$tb_rut .='<th>product</th>';
			$tb_rut .='<th>quantity</th>';
			$tb_rut .='<th>vial</th>';
			$tb_rut .='<th>total cell</th>';
			$tb_rut .='<th>package</th>';
			$tb_rut .='<th>giveaway</th>';
			$tb_rut .='<th>sender</th>';
			$tb_rut .='<th>receiver</th>';
			$tb_rut .='<th>dealer person</th>';
			$tb_rut .='<th>dealer company</th>';
			$tb_rut .='<th>price tate</th>';
			$tb_rut .='<th>note</th>';
		$tb_rut .='</tr>';
	$tb_rut .='</thead>';
	$tb_rut .='<tbody>';
	foreach ($data as &$value) {
		
		$tb_rut .='<tr>';
			$tb_rut .='<td id = "delivery_date_time">'.$value['delivery_date_time'].'</td>';
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
$new_tb .='      <style>';
$new_tb .=' 
		h2 {
		  text-align: center;
		  padding: 20px 0;
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

		  border-style: ridge;
		  border-radius: 3px;
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
//----------------------------------------------------------
$new_tb .= $tb_rut;
//----------------------------------------------------------
$new_tb .='   </body>';
$new_tb .='</html>';



$html_mail = $new_tb;
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

    //Recipients
    $mail->setFrom('celtac.order@gmail.com', 'Order-Cell.');
	
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
    $mail->Subject = 'Celtac, Here is the confirm your order or update.';
    $mail->Body    = $html_mail;
    $mail->AltBody = '';

    $mail->send();
	
    $result["success"] = true;
	echo json_encode($result);
	
} catch (Exception $e) {
	$result["success"] = false;
	echo json_encode($result);
}