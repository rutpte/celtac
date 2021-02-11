<?php
require dirname(__FILE__) . '/includes/init.inc.php';

$rs_permis 	= in_array("order_cell", $_SESSION['permissions']);
if($rs_permis){
	header("Location: http://" . $_SERVER['HTTP_HOST'] ."/".PROJ_NAME. "/customer_page.php");
}else{
	header("Location: http://" . $_SERVER['HTTP_HOST'] ."/".PROJ_NAME. "/login.html");
}


?> 

