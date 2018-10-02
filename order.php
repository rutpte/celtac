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
		$q   = isset($_POST['q']) ? $_POST['q'] : '';
		$obj = new Order($pdo);
		switch ($q) {
			case "add_order" : //--> still not use on this case from js.
				echo $obj->addOrder($_POST);
				//json_encode
			break;			
			case "delete_order" : //--> still not use on this case from js.
				$id       = isset($_POST['id']) ? intval($_POST['id']) : '';
				echo $obj->deleteOrder($id);
			break;
			
			case "get_order" :
				$rs = array();
				$rs["success"] = false;

				
				$rs = $obj->getOrder ();
				
				echo $rs;
				
			break;
		}
	}

 } else {
	$result['success'] = false;
	echo json_encode($result);
 }
