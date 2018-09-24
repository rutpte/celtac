<?php   
session_start();
require_once dirname(__FILE__) . '/includes/init.inc.php';
header('Content-type: application/json');
 if (isset($_SESSION['email'])) {
	if ($_SERVER["REQUEST_METHOD"] == "GET") {
		$q = isset($_GET['q']) ? $_GET['q'] : '';
		switch ($q)
		{
			case "xxx" :
				$obj = new Xxxx($pdo);
				echo $obj->getXxx();
				exit;
			break;
		}
	} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$q        = isset($_POST['q']) ? $_POST['q'] : '';
		$obj = new UserManage($pdo);
		switch ($q) {
			case "xxx" : //--> still not use on this case from js.
				echo $obj->get_xxx();
				//json_encode
			break;
			case "get_oder" :
				$rs = array();
				$rs["success"] = false;

				if ($_SESSION['is_superuser']) {
					$rs = $obj->get_oder ();
				} 
				echo $rs;
				
			break;
		}
	}

 }
