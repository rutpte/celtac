<?php
require dirname(__FILE__) . '/includes/init.inc.php';
if($_SESSION['email']){
	if($_SESSION['is_superuser']){

		header("Location: http://" . $_SERVER['HTTP_HOST'] ."/".PROJ_NAME. "/admin_page.php");

	} else if($_SESSION['is_staff']){

		header("Location: http://" . $_SERVER['HTTP_HOST'] ."/".PROJ_NAME. "/staff_page.php");

	} else {

		header("Location: http://" . $_SERVER['HTTP_HOST'] ."/".PROJ_NAME. "/customer_page.php");

	}
} else {
	header("Location: http://" . $_SERVER['HTTP_HOST'] ."/".PROJ_NAME. "/login.html");
}

?> 

