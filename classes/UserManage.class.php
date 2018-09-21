<?php
/************************************************
 | Class name  : UserManage.class.php           |
 | Last Modify : Jan 2013                       |
 | By          : rut                            |
 | E-mail      : zerokung_2011@hotmail.com      |
 ************************************************/

class UserManage extends DBConnection
{
    /**
     * Stores a database object
     * 
     * @var object A database object
     */
    public $id;

    /**
     * __construct — Initialization connect to database. 
     *
     * @param object $dbo a database object
     * @return No value is returned.
     */
     public function __construct($pdo=null, $post=null)
    {
        parent::__construct($pdo);

        $this->post = $post;

    }

    public function addUser($post)
    {
		//var_dump($post);exit;
		if(!$_SESSION['is_superuser']){
			$result['success'] = false;
			return json_encode($result);
		}
		
        $sql = "
            INSERT INTO staff (
                company
				, passwd
				, first_name
				, last_name
				, email
				, phone_no
				, is_staff
				, is_active
				, is_superuser
				, date_joined
				, address
            )
            VALUES (
				'{$post['company']}'
				, '{$post['pass']}'
				, '{$post['firstName']}'
				, '{$post['lastName']}'
				, '{$post['email']}'
				, '{$post['phone']}'
				, {$post['is_staff']}
				, true
				, false
				, NOW()
				, '{$post['address']}'
			);
        ";
//echo '<pre>';
//echo $sql;
        try {
            $sth = $this->db->prepare($sql);
			
			/*
            $sth->bindValue(':company', $post['company']);
            $sth->bindValue(':passwd', $post['passwd']);
            $sth->bindValue(':first_name', $post['firstName']);
            $sth->bindValue(':last_name', $post['lastName']);
            $sth->bindValue(':email', $post['email']);
            $sth->bindValue(':phone_no', $post['phone_no']);
			*/


            $sth->execute();

            $result = array();
            if ($sth->rowCount() > 0) {
                $result['success'] = true;
            } else {
                $result['success'] = false;
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

        return json_encode($result);
    }

    public function updateUser($id, $isAdmin=null)
    {
        $updateusername = ($isAdmin == 'true') ? "username     = :username," : '';

        $sql = "
            UPDATE staff SET
                {$updateusername}
                first_name   = :first_name,
                last_name    = :last_name,
                email        = :email,
                phone_no     = :phone_no,
                institute_id = :institute_id
            WHERE id = :owner_id
        ";

        try {
            $sth = $this->db->prepare($sql);

            if ($isAdmin == 'true') {
                $sth->bindValue(':username', $this->post['username']);
            }
            $sth->bindValue(':first_name', $this->post['first_name']);
            $sth->bindValue(':last_name', $this->post['last_name']);
            $sth->bindValue(':email', $this->post['email']);
            $sth->bindValue(':phone_no', $this->post['phone_no']);
            $sth->bindValue(':institute_id', $this->post['institute_id']);
            $sth->bindValue(':owner_id', $id);

            $sth->execute();
//             var_dump($sth, $this->db->errorInfo());
//             $sth->debugDumpParams();
            $result = array();
            if ($sth->rowCount() > 0) {
                $result['success'] = true;

                if (!$isAdmin) {
                    // Change session userinfo when manage saved
                    $_SESSION['first_name']      = $first_name ;
                    $_SESSION['last_name']       = $last_name;
                    $_SESSION['institute_id']    = $institute_id;
                    $_SESSION['email']           = $email;
                    $_SESSION['phone_no']        = $phone_no;
                }
            } else {
                $result['success'] = false;
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }

        return json_encode($result);
    }

    public function changePasswd($id, $new_passwd=null, $old_passwd=null, $isAdmin=null)
    {
        $sql = "SELECT COUNT(*) AS passwd FROM staff WHERE id={$id}";

        if ($isAdmin == 'false') {
            $sql .= " AND passwd = '$old_passwd'";
        }

        $res = $this->db->query($sql)->fetchObject();

        if ($res->passwd > 0) {
            $sql = "
                UPDATE staff SET
                    passwd = '$new_passwd'
                WHERE id={$id}
            ";

            $res = $this->db->exec($sql);

            $result = array();
            if ($res !== false) {
                $result = array(
                    "success" => true
                );
            }
        } else {
            $result = array(
                "error_msg" => "รหัสผ่านปัจจุบันไม่ถูกต้อง",
                "success"   => false
            );
        }

        return json_encode($result);
    }

    public function crossJSON($result, $callback)
    {
        $cross_json = '';
        if($callback) {
            $cross_json .= "$callback(";
        }

        $cross_json .= json_encode($result);

        if($callback) {
            $cross_json .= ")";
        }

        return $cross_json;
    }

//     public function admin_updateUser()
//     {
//         $owner_id = isset($_POST['id']) ? $_POST['id'] : '';
//         $username = isset($_POST['username']) ? $_POST['username'] : '';
//         $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
//         $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
//         $institute_id = isset($_POST['institute_id']) ? $_POST['institute_id'] : '';
//         $email = isset($_POST['email']) ? $_POST['email'] : '';
//         $phone_no = isset($_POST['phone_no']) ? $_POST['phone_no'] : '';
// 
//         $sql = "
//             UPDATE staff SET
//                 first_name = '{$first_name}',
//                 last_name = '{$last_name}',
//                 email = '{$email}',
//                 phone_no = '{$phone_no}',
//                 institute_id = {$institute_id}
//             WHERE id={$owner_id}
//         ";
//         
//         $sql = "
//             UPDATE staff SET
//                 first_name = '{$first_name}',
//                 last_name = '{$last_name}',
//                 email = '{$email}',
//                 phone_no = '{$phone_no}',
//                 institute_id = {$institute_id}
//             WHERE id={$owner_id}
//         ";
// 
//         $res = $this->db->exec($sql);
// 
//         if ($res !== false) {
//             $result = array(
//                 "success" => true
//             );
//         }
// 
//         return $result;
//     }
    

    
    public function getUserStore () {
        $query    = isset($_GET["query"]) ? trim($_GET["query"]) : "";
        $callback = isset($_GET["callback"]) ? $_GET["callback"] : false;
        $limit    = isset($_GET["limit"]) ? $_GET["limit"] : 20;
        $start    = isset($_GET["start"]) ? $_GET["start"] : 0;
        $sort     = isset($_GET["sort"]) ? $_GET["sort"] : false;
        $dir      = isset($_GET["dir"]) ? $_GET["dir"] : "ASC";
        #--------------------------------------------------------------------
        $table='staff';
        $column='username';

        $icon_upd_a = "'<a href=\"javascript:void(0);\" onclick=\"viewer.editItem('''";
        $icon_upd_b = "''')\"><img src=\"images/png-icons/application-form-16x16.png\" /></a> '";
        $icon_del_a = "'<a href=\"javascript:void(0);\" onclick=\"viewer.deleteItem('''";
        $icon_del_b = "''')\"><img src=\"images/png-icons/cross-16x16.png\" /></a>'";   
        $sql = "
            SELECT 
                id,
                username,
                first_name,
                last_name,
                email,
                passwd,
                phone_no,
                institute_id,
                {$icon_upd_a} ||  {$icon_upd_b}  AS action
            FROM 
                {$table}";  
        if($query != "") {
            $sql .= " WHERE {$column} like :query";
        }
        if($sort) {
            $sql .= ' ORDER BY '.$sort;
            $sql .= strtoupper($dir)=='ASC'?' ASC':' DESC';
        }
        $sql .= ' LIMIT :limit OFFSET :start;';

        $sth = $this->db->prepare($sql);
        if($query != "") {
            $sth->bindValue(':query', $query.'%', PDO::PARAM_STR);
        }
        $sth->bindValue(':limit', $limit);
        $sth->bindValue(':start', $start);
        $sth->execute();

        $result = Array();
        $result["total"] = self::getTotal ($table, $query, $column);
        $result["items"] = $sth->fetchAll(PDO::FETCH_CLASS);

        return self::crossJSON($result, $callback);

    }//end_getManageUser

    public function getTotal ($table, $query, $column)
    {
        $condition = ($query != '' ? " WHERE ".$column." ILIKE '".$query."%'" : null);
        $sql = "SELECT count(*) FROM {$table} {$condition}";

        return $this->db->query($sql)->fetchObject()->count;
    }
	
    public function getPermissionLayer ($username)
    {
        $sql ="
            select 
                layer_name
            from user_permission_layers
            where user_name = '{$username}'
        ";
        //echo "<pre>", $sql; exit;
        $sth = $this->db->prepare($sql);  //sql2
        $result = array();
        if (!$sth->execute()) {
            echo '<pre>'.$sql;
            print_r($sth->errorInfo());
        } else {
            
            //$result = $sth->fetchObject();
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($result);
        }
    }
    public function savePermissionLayer ($user_name, $data)
    {
        //--> first DELETE data all where user_name
        $sql_del = "
            DELETE FROM user_permission_layers
            WHERE user_name = '{$user_name}';
        ";
        //echo "<pre>", $sql_del; exit;
        $sth_del = $this->db->prepare($sql_del);  //$sql_del
        if (!$sth_del->execute()) {
            echo '<pre>'.$sql_del;
            print_r($sth_del->errorInfo());
            exit;
        } else {
            //no action and go to run INSERT data below
        }
        //---------------------------------------------------
        
        //--> INSERT new data where user_name
        $sql = "
            INSERT INTO user_permission_layers 
                (user_name, layer_name) VALUES 
        ";
		if($data != "") {
			$sql .= $data;
			$sth = $this->db->prepare($sql);  //sql
			$result = array();
			if (!$sth->execute()) {
				echo '<pre>"'.$sql;
				echo '"-------------------';
				echo '<br>';
				print_r($sth->errorInfo());
			} else {
				$result = array(
					'success'       => true
				);
				return json_encode($result);
			}
		} else {
				$result = array(
					'success'       => true
					,'msg' => 'none data to save in database'
				);
				return json_encode($result);
		}

    }
    //---------------------------------------------------------
    
    public function getEmail ($username)
    {
        $sql ="
            select 
                email
            from staff
            where username = '{$username}'
        ";
        //echo "<pre>", $sql; exit;
        $sth = $this->db->prepare($sql);  //sql2
        $result = array();
        if (!$sth->execute()) {
            echo '<pre>'.$sql;
            print_r($sth->errorInfo());
        } else {
            
            //$result = $sth->fetchObject();
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($result);
        }
    }
    //---------------------------------------------------------
    public function random_str( $length = 18 ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@$^()_-=;:,.?";
        $secure_code = substr( str_shuffle( $chars ), 0, $length );
        return $secure_code;
    }
    //---------------------------------------------------------
    public function prepareResetPassword ($username, $email, $new_password)
    {
        $secure_code = self::random_str();
        //echo $random_str;exit;
        //$today = date("d-m-Y H:i:s"); 
        $sql = "
            INSERT INTO reset_password (username, email, new_password, date_prepare, secure_code)
            VALUES ('{$username}', '{$email}', md5('{$new_password}'), now(), '{$secure_code}') RETURNING id
        ";
        
        //echo "<pre>", $sql; exit;
        try {
            $id_insert = $this->db->query($sql)->fetchObject(); 
            //var_dump($id_insert->id);exit;
            //self::mail_reset_password ($email, $id_insert->id);
            return '{"id_insert" : '.$id_insert->id.',"secure_code" : "'.$secure_code.'"}';
        } catch (Exception $e) {
            echo '<pre>';
            echo $sql ;
            exit;
        }

        //------------------------------------------------------
        //$result = array();
        //$sth = $this->db->prepare($sql);  //sql2
//         if (!$sth->execute()) {
//             echo '<pre>'.$sql;
//             print_r($sth->errorInfo());
//         } else {
//             
//             //$result = $sth->fetchObject();
//             $result = $sth->fetchAll(PDO::FETCH_ASSOC);
//             return json_encode($result);
//         }
    }
    //---------------------------------------------------------
    public function confirmResetPassword ($id_reset, $secure_code)
    {
        //$today = date("d-m-Y H:i:s"); 
        //--> get data from data_prepara before comfrim by email
        $sql_get_data = "
            select * 
            from reset_password
            where id = {$id_reset}
            and secure_code = '{$secure_code}'
        ";
        //echo "<pre>", $sql_get_data; exit;
        //------------------------------------------------------
        $sth_get_data = $this->db->prepare($sql_get_data);
        //$result = array();
        if (!$sth_get_data->execute()) {
            echo '<pre>'.$sql_get_data;
            print_r($sth_get_data->errorInfo());
        } else {
            //--> update
            $result_prepare_data = $sth_get_data->fetchAll(PDO::FETCH_ASSOC);
            //var_dump($result_prepare_data);
            if (!empty($result_prepare_data)) {
                $time_ask_reset = $result_prepare_data[0]["date_prepare"];
                $username       = $result_prepare_data[0]["username"];
                $new_password   = $result_prepare_data[0]["new_password"];
                //var_dump($time_ask_reset);
                //$today = date("d-m-Y H:i:s");
                
                $time_prepare    = @strtotime($time_ask_reset);
                $time_now        = @strtotime("now");
                
                $different_time  = $time_now - $time_prepare;
                $condition_time  = 20*60; //20 minute
                //var_dump($time_prepare,$time_now,strtotime("+1 day"),24*60*60);exit;
                
                if($different_time <= $condition_time){
                    //echo $different_time;
                    //echo "ok date in 60 seccond";
                    $sql_update_password = "
                        UPDATE staff
                        SET passwd='{$new_password}'
                        WHERE username='{$username}';
                    ";
                    //echo "<pre>", $sql_update_password; exit;
                    $sth = $this->db->prepare($sql_update_password);
                    $result = array();
                    if (!$sth->execute()) {
                        echo '<pre>'.$sql_update_password;
                        print_r($sth->errorInfo());
                    } else {
                        //$result = $sth->fetchAll(PDO::FETCH_ASSOC);
                        $result = array(
                            'success'       => true
                        );
                        return $result;
                    }
                } else {
                    echo $different_time ." sec <br>";
                    echo "date expired, ";
                }
            } else {
                echo "no data for reset, ";
                //--echo '<pre>'.$sql_get_data;
            }

        }
    }
    //-------------------------------------------------------------
    
    public function get_all_user ()
    {
        $sql ="
            select 
				id
				,company
				,first_name
				,last_name
				,email
				,is_staff
				,is_superuser
				,last_login
				,date_joined
				,phone_no
				,address
            from staff
			where 1=1
			and is_superuser != 't'
        ";
        //echo "<pre>", $sql; exit;
        $sth = $this->db->prepare($sql);  //sql2
        $result = array();
        if (!$sth->execute()) {
            echo '<pre>'.$sql;
            print_r($sth->errorInfo());
        } else {
			$get_num_row = $sth->rowCount();
            //var_dump($sth->rowCount());
            //$result = $sth->fetchObject();
			if($get_num_row > 0){
				$result = $sth->fetchAll(PDO::FETCH_ASSOC);
				
				//$result["success"] = true;
				return ($result);
			} else {
				$result["success"] = false;
				return ($result);
			}
        }
    }
    //---------------------------------------------------------
    /**
     * __destruct
     * 
     * @return No value is returned.
     */
    public function __destruct() 
    {
        parent::__destruct();
    }
}