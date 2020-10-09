<?php
require dirname(__FILE__) . '/includes/init.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$q = isset($_POST["q"]) ? trim($_POST["q"]) : "";
	
    switch(strtolower($q)) {
        case "login" :
			$email   	= isset($_POST['email']) ? $_POST['email'] : '';
			$passwd     = isset($_POST['passwd']) ? $_POST['passwd'] : '';
            
            $auth = new Authentication($pdoCeltac);//pdoAuthen,pdoCeltac
			
			//--> create sesstion.
            $loged_in_rs = $auth->login($email, $passwd);
			//print_r ($loged_in_rs); 
			//var_dump($loged_in_rs);
			//var_dump($loged_in_rs["success"]);
			
			//exit();
			if ($loged_in_rs["success"]) {
				echo json_encode($loged_in_rs);
				//exit();
			} else {
				$login_error_msg = array();
				$login_error_msg["success"] = false;
				if ($email == '') {
					$login_error_msg["msg"] = 'กรุณากรอกชื่อผู้ใช้';
				} else if ($passwd == '') {
					$login_error_msg["msg"] = 'กรุณากรอกรหัสผ่าน';
				} else {
					$login_error_msg["msg"] = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
				}
				
				echo json_encode($login_error_msg);
			}
        break;
        case "logout" :
			//--> destroy all seesion.
			session_destroy();
        break;
        // --> if don't post "q" parameter
        default:
            $result='{"success default":false}';
			echo json_encode($result);
    }
	//end switch
	
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	$q = isset($_GET["q"]) ? trim($_GET["q"]) : "";
    switch(strtolower($q)) {
        case "login" :
			echo 'login method get.';
        break;
        case "logout" :
			//--> destroy all seesion.
			session_destroy();
        break;
        case "auto_login" :
			//--> destroy all seesion.
            $username   = 'narong';
            $passwd     = '1234';
            $mem_passwd = 0;
            // $_SESSION['phase_edit'] = true;
            $auth = new Authentication($pdoAuthen);//pdoAuthen,pdoCeltac

            $loged_in = $auth->login($username, $passwd, $mem_passwd, false);

            if ($loged_in) {
                //--header('Location: http://' . $_SERVER['HTTP_HOST'] . PROJ_NAME . '/xxxx.php');
            } else {
                echo 'can not login from "open in new tap"';
            }
        break;
        // --> if don't post "q" parameter
        default:
            $result='{"success":false}';
			echo json_encode($result);
    }
}

