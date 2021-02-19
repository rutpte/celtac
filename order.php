<?php   
session_start();
require_once dirname(__FILE__) . '/includes/init.inc.php';
header('Content-type: application/json');
$rs_permis = in_array("order_cell", $_SESSION['permissions']);
if($rs_permis){
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
			//--------------------------------------------
			case "add_order" :
				echo $obj->addOrder($_POST);
				//json_encode
			break;	
			//--------------------------------------------
			case "edit_order" :
				echo $obj->updateOrder($_POST);
				//json_encode
			break;
			//--------------------------------------------
			case "delete_order" :
				$id       = isset($_POST['id']) ? intval($_POST['id']) : '';
				echo $obj->deleteOrder($id);
			break;
			//--------------------------------------------
			case "get_order" :
				$rs = array();
				$rs["success"] = false;

				
				$rs = $obj->getOrder ();
				
				echo $rs; 
				
			break;
			//--------------------------------------------
			case "get_order_all" : //use on auto email.
				$rs = array();
				$rs["success"] = false;

				
				$rs = $obj->getOrderAll ();
				
				echo $rs;
				
			break;
			//--------------------------------------------
			case "change_active" :
				$id       = isset($_POST['id']) ? intval($_POST['id']) : '';
				echo $obj->changeActive($id);
			break;
			//--------------------------------------------
		}
	}

} else {
	$result['success'] = false;
	echo json_encode($result);
}
