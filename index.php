<?php
require dirname(__FILE__) . '/includes/init.inc.php';
//var_dump($_SESSION['permissions']);exit;

$see_order_lab_permis 	= in_array("see_order_lab", $_SESSION['permissions']);
$order_cell_permis 		= in_array("order_cell", $_SESSION['permissions']);

if($see_order_lab_permis){
	header("Location: http://" . $_SERVER['HTTP_HOST'] ."/".PROJ_NAME. "/see_order_page.php");
}else if($order_cell_permis){
	header("Location: http://" . $_SERVER['HTTP_HOST'] ."/".PROJ_NAME. "/customer_page.php");
}else {
	header("Location: http://" . $_SERVER['HTTP_HOST'] ."/".PROJ_NAME. "/login.html");
}


?> 

