<?php   
session_start();
require_once dirname(__FILE__) . '/includes/init.inc.php';
header('Content-type: application/json');
if ($_SESSION['is_superuser'] =='t') {
	if ($_SERVER["REQUEST_METHOD"] == "GET") {
		$q = isset($_GET['q']) ? $_GET['q'] : '';
		switch ($q)
		{
			case "userstore" :
				$mu = new UserManage($pdo);
				echo $mu->getUserStore();
				exit;
			break;
			
			case "get_permission_layer" :
				$username = isset($_GET['username']) ? $_GET['username'] : '';
				$mu = new UserManage($pdo);
				echo $mu->getPermissionLayer($username);
				exit;
			break;
			
			case "get_email" :
				$username = isset($_GET['username']) ? $_GET['username'] : '';
				$mu = new UserManage($pdo);
				echo $mu->getEmail($username);
				exit;
			break;
			case "reset_password" :
				$username       = isset($_GET['username']) ? $_GET['username'] : '';
				$email          = isset($_GET['email']) ? $_GET['email'] : '';
				$new_password   = isset($_GET['new_password']) ? $_GET['new_password'] : '';
				
				$mu = new UserManage($pdo);
				echo $mu->prepareResetPassword($username, $email, $new_password);
				
				//-->
				exit;
			break;
		}
	} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$q        = isset($_POST['q']) ? $_POST['q'] : '';
		$mu = new UserManage($pdo);
		switch ($q) {
			case "get_all_user" : //--> still not use on this case from js.
				echo $mu->get_all_user();
				//json_encode
			break;
			case "add_user" :
				echo $mu->addUser($_POST);
			break;			
			case "update_user" :
				echo $mu->updateUser($_POST);
			break;
			case "delete_user" :
				$id       = isset($_POST['id']) ? intval($_POST['id']) : '';

				echo $mu->deleteUser($id);
			break;			case "edit" :
				$id       = isset($_POST['id']) ? intval($_POST['id']) : '';
				$is_admin = isset($_POST['is_admin']) ? $_POST['is_admin'] : '';

				echo $mu->updateUser($id, $is_admin);
			break;
			case "changePasswd" :
				$id   = isset($_POST['id']) ? $_POST['id'] : null;
				$old_passwd = isset($_POST['old_passwd']) ? md5($_POST['old_passwd']) : '';
				$new_passwd = isset($_POST['new_passwd']) ? md5($_POST['new_passwd']) : '';

				echo $mu->changePasswd($id, $new_passwd, $old_passwd, $is_admin);
			break;
			
			case "edit_layer" :
				//--> change permission layer access
					$arr       = $_POST;
					$user_name = $_POST['user_name'];
					$str_val = "";
					
					//--> prepare data array to insert db
					foreach ($arr as $key => $value) {
						//echo "Key: $key; Value: $value<br />\n";
						$key_name = substr($key, 0, 19);
						if($key_name == "edit_layer_checkbox"){
							$str_val .= "(";
							$str_val .= "'".$user_name."'".","."'".$value."'";
							$str_val .= "),";
						}
					}
					
					//--> after finish loop prepare data then delete comma in the last and assign to $data
					$data = substr_replace($str_val, "", -1);
					//--> send to class function with $user_name and $data
					echo $mu->savePermissionLayer ($user_name, $data);
			break;
			
			case "edit_layer_permission" :
				//--> change permission layer access
					$data      = json_decode($_POST['jsondata']);
					$user_name = $_POST['user_name'];
					//var_dump($data);exit;
					//--> prepare data array to insert db
					foreach ($data as $key => $value) {
						$str_val .= "(";
						$str_val .= "'".$user_name."'".","."'".$value."'";
						$str_val .= "),";
					}
					
					//--> after finish loop prepare data then delete comma in the last and assign to $data
					$value_db = substr_replace($str_val, "", -1);
					//echo $value_db; exit;
					//--> send to class function with $user_name for delete and add new with $value_db.
					echo $mu->savePermissionLayer ($user_name, $value_db);
			break;
			case "get_all_user" :
				$rs = array();
				$rs["success"] = false;

				if ($_SESSION['is_superuser']) {
					$rs = $mu->get_all_user ();
				} 
				echo $rs;
				
			break;
		}
	}

 }
