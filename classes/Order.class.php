<?php
/************************************************
 | Class name  : UserManage.class.php           |
 | Last Modify : Jan 2013                       |
 | By          : rut                            |
 | E-mail      : zerokung_2011@hotmail.com      |
 ************************************************/

class Order extends DBConnection
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
     public function __construct($pdo=null)
    {
        parent::__construct($pdo);
    }

    public function addOrder($post)
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
    public function deleteOrder($id, $isAdmin=null)
    {
		if(!$_SESSION['is_superuser']){
			$result['success'] = false;
			return json_encode($result);
		}
		//-------------------------------
        $sql = "
            UPDATE staff SET
                is_active = false
            WHERE id = {$id}
        ";

        try {
            $sth = $this->db->prepare($sql);

            $sth->execute();
//             var_dump($sth, $this->db->errorInfo());
//             $sth->debugDumpParams();
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
    public function updateOrder($post)
    {
		if(!$_SESSION['is_superuser']){
			$result['success'] = false;
			return json_encode($result);
		}
		//-------------------------------
		if ($post['pass'] != ""){
			$update_passwd = ", passwd		= '{$post['pass']}'";
		} else {
			$update_passwd = "";
		}
        

        $sql = "
            UPDATE staff SET
                company 		= '{$post['company']}'
					{$update_passwd}
				, first_name	= '{$post['firstName']}'
				, last_name		= '{$post['lastName']}'
				, email			= '{$post['email']}'
				, phone_no		= '{$post['phone']}'
				, is_staff		= '{$post['is_staff']}'
				, address		= '{$post['address']}'
            WHERE id = {$post['id']}
        ";
// echo '<pre>';
// echo $sql; exit;
        try {
            $sth = $this->db->prepare($sql);

            $sth->execute();
//             var_dump($sth, $this->db->errorInfo());
//             $sth->debugDumpParams();
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
    //-----------------------------------------------------------------
    public function getOrder ()
    {
        $sql ="
            select 
				*
            from order_product
			where 1=1
			and user_id = '{$_SESSION['owner_id']}'
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
    //-----------------------------------------------------------------
    public function getAllOrder ()
    {
        $sql ="
            select 
				*
            from order_product
			where 1=1

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