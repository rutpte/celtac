<?php
require dirname(__FILE__) . '/includes/init.inc.php';
 if (isset($_SESSION['email'])) {
	$obj 	= new Order($pdo);
	$rs_arr = $obj->getOrderAll();
	foreach ($rs_arr as &$value) {
		echo $value['id'];
		echo $value['order_code'];
		echo ' | ';
	}
	exit;
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
$from_email_pass  	= 'celtac123';
//$mailTo 			= array("yupa.pangtum@gmail.com", "thongjet@hotmail.com", "my_name_is_ken@live.com", "iloveubon@gmail.com", "zerokung_2011@hotmail.com");
$mailTo 			= array("iloveubon@gmail.com");

//-----------------------------------------------------------------------------------------
$new_tb="";

$new_tb .='<table class="CSSTableGenerator"  name = "xxx">';
	$new_tb .='<thead>';
		$new_tb .='<tr>';
		
			$new_tb .='<th>xxxx</th>';
			$new_tb .='<th>xxxx</th>';
			$new_tb .='<th>xxxx</th>';
			$new_tb .='<th>xxxx</th>';
			$new_tb .='<th>xxxx</th>';
			$new_tb .='<th>xxxx</th>';
			$new_tb .='<th>xxxx</th>';
			$new_tb .='<th>xxxx</th>';
			$new_tb .='<th>xxxx</th>';
			$new_tb .='<th>xxxx</th>';
			$new_tb .='<th>xxxx</th>';
			$new_tb .='<th>xxxx</th>';
			$new_tb .='<th>xxxx</th>';
			$new_tb .='<th>xxxx</th>';
			$new_tb .='<th>xxxx</th>';
		$new_tb .='</tr>';
	$new_tb .='</thead>';
	$new_tb .='<tbody>';
		$new_tb .='<tr>';
			$new_tb .='<td style="width: 6.6%;" id = "'.$xxx.'">'.$xxx.'</td>';
			$new_tb .='<td style="width: 6.6%;" id = "'.$xxx.'">'.$xxx.'</td>';
			$new_tb .='<td style="width: 6.6%;" id = "'.$xxx.'">'.$xxx.'</td>';
			$new_tb .='<td style="width: 6.6%;" id = "'.$xxx.'">'.$xxx.'</td>';
			$new_tb .='<td style="width: 6.6%;" id = "'.$xxx.'">'.$xxx.'</td>';
			$new_tb .='<td style="width: 6.6%;" id = "'.$xxx.'">'.$xxx.'</td>';
			$new_tb .='<td style="width: 6.6%;" id = "'.$xxx.'">'.$xxx.'</td>';
			$new_tb .='<td style="width: 6.6%;" id = "'.$xxx.'">'.$xxx.'</td>';
			$new_tb .='<td style="width: 6.6%;" id = "'.$xxx.'">'.$xxx.'</td>';
			$new_tb .='<td style="width: 6.6%;" id = "'.$xxx.'">'.$xxx.'</td>';
			$new_tb .='<td style="width: 6.6%;" id = "'.$xxx.'">'.$xxx.'</td>';
			$new_tb .='<td style="width: 6.6%;" id = "'.$xxx.'">'.$xxx.'</td>';
			$new_tb .='<td style="width: 6.6%;" id = "'.$xxx.'">'.$xxx.'</td>';
			$new_tb .='<td style="width: 6.6%;" id = "'.$xxx.'">'.$xxx.'</td>';
			$new_tb .='<td style="width: 6.6%;" id = "'.$xxx.'">'.$xxx.'</td>';
			
		$new_tb .='</tr>';
	$new_tb .='</tbody>';
$new_tb .='</table>';
//-----------------------------------------------------------------------------------------
$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
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
    $mail->Subject = 'Here is the subject';
    $mail->Body    = $html_mail;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
	
    $result["success"] = true;
	echo json_encode($result);
	
} catch (Exception $e) {
	$result["success"] = false;
	echo json_encode($result);
}