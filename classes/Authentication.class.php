<?php
/******************************************
 | Class name  : Authentication.class.php |
 | Last Modify : Jan 2013                 |
 | By          : Narong Rammanee          |
 | E-mail      : ranarong@live.com        |
 ******************************************/

class Authentication extends DBConnection
{
    /**
     * __construct — Initialization
     *
     * @return No value is returned.
     */
    public function __construct($pdo=null)
    {
        parent::__construct($pdo);
    }

    public function login ($username, $passwd)
    {
        $strSQL = "
            SELECT 
                stf.*
            FROM staff stf 
            WHERE 1=1
			AND email = :username 
			AND passwd = :passwd
			AND is_active = 't'
        ";
		
        //echo '<pre>'.$strSQL; exit;
        $sth = $this->db->prepare($strSQL);

        $sth->bindValue(':username', $username, PDO::PARAM_STR);
        $sth->bindValue(':passwd', $passwd, PDO::PARAM_STR);
        $sth->execute();
//             var_dump($sth, $this->db->errorInfo());
//             $sth->debugDumpParams();
//			   var_dump($sth);

        $result = $sth->fetchObject();

        if ($result !== false) {
            // Update last login
            $strSQL = "UPDATE staff SET last_login = NOW() WHERE id = :id";

            $sth = $this->db->prepare($strSQL);

            $sth->bindValue(':id', $result->id, PDO::PARAM_INT);
            $sth->execute();
            
            //----------------------------------

            // Set PHP session for refresh page
            $_SESSION['owner_id']        = $result->id;
            //$_SESSION['username']        = $result->username;
            $_SESSION['first_name']      = $result->first_name;
            $_SESSION['last_name']       = $result->last_name;
            $_SESSION['email']           = $result->email;
            $_SESSION['phone_no']        = $result->phone_no;
			$_SESSION['is_staff']        = $result->is_staff;
            $_SESSION['is_superuser']    = $result->is_superuser;
			//echo "xxxxx";
			//print_r($_SESSION);
			//exit;
            // JSON array for javasrcipt
            //--> where to use this json, it not use because if reload page it will gone.
            $rs_array = array(
                'owner_id'        => $result->id,
                'first_name'      => $result->first_name,
                'last_name'       => $result->last_name,
                'email'           => $result->email,
                'phone_no'        => $result->phone_no,
                'company'         => $result->company,
                'is_superuser'    => $result->is_superuser,
				'is_staff'    	  => $result->is_staff,
                'success'         => true
            );
        }  else {
            $rs_array = array(
                'success' => false
            );
        }

        return $rs_array;
    }

    public function logout()
    {
        session_destroy();

        $rs_array = array(
            'success' => 'true'
        );
		return $rs_array;
        //return json_encode($rs_array);
    }

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