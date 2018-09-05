<?php
require dirname(__FILE__) . '/includes/init.inc.php';
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

$from_email 		= 'pte.engineer@gmail.com';
$from_email_pass  	= 'xxx';
$mailTo 			= array("yupa.pangtum@gmail.com", "thongjet@hotmail.com", "my_name_is_ken@live.com", "iloveubon@gmail.com", "zerokung_2011@hotmail.com");

$email_to 			= 'iloveubon@gmail.com';
$id_reset 			= isset($_GET['id_reset']) ? $_GET['id_reset'] : '';
$secure_code 		= isset($_GET['secure_code']) ? $_GET['secure_code'] : '';
$project_name 		= "celtac";
$host 				= "127.0.0.1";
//-----------------------------------------------------------------------------------------
    $link_confirm = "http://".$host."/".$project_name."/mailConfirmReset.php?id_reset=".$id_reset."&secure_code=".$secure_code;
    $html_mail = '
        <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#ebebeb">
            <tbody>
                <tr>
                    <td align="center" valign="top"></td>
                </tr>
            </tbody>
        </table>
        <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#ebebeb">
            <table style="border-left: 2px solid #e6e6e6; border-right: 2px solid #e6e6e6;" cellspacing="0" cellpadding="25" width="605">
                <td width="596" align="center" style="background-color: #ffffff; border-top: 0px solid #000000; text-align: left; height: 50px;">
                    <p style="margin-bottom: 3px; font-size: 22px; font-weight: bold; color: #494a48; font-family: arial; line-height: 110%;">
                        confirm reset password.
                    </p>
                </td>

                <tr>
                    <td style="background-color:#EEEEEE; border-top: 0px solid #333333; border-bottom: 1px solid #FFFFFF;" align="middle" valign="middle">
                        <a href="'.$link_confirm.'">Confirm Click</a>
                    </td>
                <tr>
                <td style="background-color: #ffffff; border-top: 0px solid #000000; text-align: left; height: 50px;" align="center">
                <p>
                    <span style="margin-bottom: 1px; font-size: 12px; font-weight: normal; color: #494a48; font-family: arial; line-height: 110%;">
                        this E-mail is confirmation for reset new password.
                    </span>
                </p>

                <p><a href="#"></a></p></tr>

            </table>

        <table width="604" cellpadding="1" cellspacing="0">
            <tr>
            <td width="288" bgcolor="#ffffff"><br />
            <td width="294" bgcolor="#ffffff" align="right"> 

            <tr>

            <td style="background-color: #ffffff; border-top: 0px solid #000000; text-align: left; height: 50px;" align="center">
            <span style="font-size: 10px; color: #575757; line-height: 120%; font-family: arial; text-decoration: none;">
            <a href="mailto:pte.engineer@gmail.com">
            Contact Us?</a><br>
            Visit us on the web at <a href="http://mapdb.pte.co.th/'.$project_name.'">'.$project_name.'</a></span></td>

            <td style="background-color: #ffffff; border-top: 0px solid #000000; text-align: right; height: 50px;" align="center">
            <span style="font-size: 10px; color: #575757; line-height: 120%;
            font-family: arial; text-decoration: none;">If you want more service <a href="http://pte.co.th">click here</a>.</span>
        </table>
    ';
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
    $mail->setFrom('pte.engineer@gmail.com', 'Pte');
	
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
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}