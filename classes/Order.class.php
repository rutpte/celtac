<?php
/************************************************
 | Class name  : Order.class.php           |
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

    public function addOrder($post){
		//echo "                                   Hed "; exit;
		//echo trim("                                   Hed "); exit;
		
		//var_dump($post);exit;
		//$timestamp = strtotime("26-09-2018");
		//var_dump($timestamp);exit;
		//var_dump($post);exit;
		//var_dump($_SESSION['owner_id']);exit;
		
		$hour			= $post['delivery_time_hour'];
		$minute			= $post['delivery_time_minute'];
		$date_raw 		= $post['delivery_date'];
		//2015-03-26 11:39:59
		$str_date		= $date_raw.' '.$hour.':'.$minute.':00'; //27-09-2018 14:0:00
		//echo $str_date; exit;
		//$date_full 		= new DateTime($str_date);
		$obj_date 		= new DateTime($str_date);;
		$date_formated 	= $obj_date->format('Y-m-d H:i:s');
		//$date_timestamp = strtotime($date_formated);
		//echo strtotime($date_formated); exit;
		//echo date('Y-m-d H:i:s', strtotime($test)); exit;
		//echo $str_date;
		//echo  '</br>';
		//echo strtotime($str_date);exit;
		//echo date('Y-m-d', strtotime($str_date)); exit;
		//--$date_formated 	= $date_full->format('d-m-Y H:i:s');
		//$date_formated 	= $date_full;
		//echo $date->format('d-m-Y');
		//echo $date_formated; exit;

		$array_product = json_decode($_POST['items_json'],true);
		//var_dump($array_product);
		//echo 'testing';
		
		$str_value_raw = "";
		foreach ($array_product as $value) {
			
			// echo 'product_type : '.$value['product_type'];
			// echo 'quantity : '.$value['quantity'];
			// echo 'vial : '.$value['vial'];
			// echo 'total_cel : '.$value['total_cel'];
			// echo 'package_type : '.$value['package_type'];
			// echo 'giveaway : '.$value['giveaway'];
			// echo '--------------------';

			$order_code			= isset($post['order_code']) 			? "'".$post['order_code']."'" 										: 'null';
			$customer_name		= isset($post['customer_name']) 		? "'".$post['customer_name']."'"									: 'null';
			$product_type		= $value['product_type'] 	!= "" ? "'".$value['product_type']."'"											: 'null';
			$quantity			= $value['quantity'] 		!= "" ? $value['quantity']														: 'null';
			$set				= $value['set'] 			!= "" ? $value['set']															: 'null';
			$vial				= $value['vial'] 			!= "" ? $value['vial']															: 'null';
			$total_cell			= $value['total_cell'] 		!= "" ? $value['total_cell']													: 'null';
			$package_type		= $value['package_type'] 	!= "" ? "'".$value['package_type']."'"											: 'null';
			$giveaway			= $value['giveaway'] 		!= "" ? "'".$value['giveaway']."'"												: 'null';
			$price_rate			= $value['price_rate'] 		!= "" ? "'".$value['price_rate']."'"											: 'null';
			
			//--> not use is_active from json.
			//$is_active			= $value['is_active'] ? 'true' : 'false';
			//var_dump($is_active); exit;
			//$delivery_time		= isset($post['delivery_date']) 	? strtotime($post['delivery_date']) 	: '';
			$delivery_date_time	= isset($post['delivery_date']) 		? "'".$date_formated."'" 											: 'null';

			$sender				= isset($post['sender']) 				? "'".$post['sender']."'" 											: 'null';
			$receiver			= isset($post['receiver']) 				? "'".$post['receiver']."'" 										: 'null';
			$dealer_person		= isset($post['dealer_person']) 		? "'".$post['dealer_person']."'" 									: 'null';
			$dealer_company		= isset($post['dealer_company']) 		? "'".$post['dealer_company']."'" 									: 'null';
			$user_id			= isset($_SESSION['owner_id']) 			? $_SESSION['owner_id']												: 'null';
			//$last_update_date 	= isset($post['last_update_date']) 	? $post['last_update_date'] : '';
			//$price_rate			= isset($post['price_rate']) 			? "'".$post['price_rate']."'"										: 'null';
			$comment_else		= isset($post['comment_else']) 			? "'".$post['comment_else' ]."'"									: 'null';
			
			$sta_allow_time_deliv = $this->check_diff_time_by_strtime($delivery_date_time, 300);
			//check time deliv and cell number. or is_staff can be access.
			if(($sta_allow_time_deliv == 1) && ($total_cell <= 10)){
				$is_active = 'true';
			} else {
				$is_active = 'false';
			}
			//var_dump($is_active); exit;
			//---------------------------------------------------------------------------------------------------------------------------------------
			$str_value_raw .= "
				(
				{$order_code}
				, {$customer_name}
				, {$product_type}
				, {$quantity}
				, {$set}
				, {$vial}
				, {$total_cell}
				, {$package_type}
				, {$delivery_date_time}
				, {$giveaway}
				, {$sender}
				, {$receiver}
				, {$dealer_person}
				, {$dealer_company}
				, {$user_id}
				, NOW()
				, NOW()
				, {$price_rate}
				, {$comment_else}
				, {$is_active}
				),";

		} //end loop value.
		//echo $str_value_raw;
		$rs_value = substr($str_value_raw, 0, -1);
		//$xx = rtrim($str_value, ',');
		// echo $rs_value;
		// exit;
		//json_decode($jsondata, true);


        $sql = "
            INSERT INTO order_product (
				order_code 
				,customer_name 
				,product_type 
				,quantity  
				,set
				,vial 
				,total_cell 
				,package_type 
				,delivery_date_time
				,giveaway 
				,sender 
				,receiver 
				,dealer_person 
				,dealer_company 
				,user_id 
				,order_date 
				,last_update_date 
				,price_rate 
				,comment_else 
				,is_active 
            )
            VALUES {$rs_value}
        ";
//echo '<pre>';
//echo $sql; exit;
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
    public function deleteOrder($id)
    {
		$sta_allow = $this->check_diff_time_by_id($id, 300); //--> 300 minute == 5 hours.
		//--var_dump($sta_allow); exit;
		if($sta_allow == 1 || $_SESSION['is_staff']){
			//-------------------------------
			/*
			$sql = "
				UPDATE order_product SET
					is_active = false
				WHERE id = {$id}
			";
			*/
			$sql = "
				DELETE FROM order_product
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
			//---------------------------------------------
		}else{ //$sta_allow == 0
			$result['success'] = false;
			return json_encode($result);
		}
		

    }
    public function updateOrder($post){
		$sta_allow = $this->check_diff_time_by_id($post['order_id_edit'], 300); //--> 300 minute == 5 hours.
		//--var_dump($sta_allow); exit;
		if($sta_allow == 1 || $_SESSION['is_staff']){
				//---------------------------------------------

			$user_id			= isset($_SESSION['owner_id']) ? $_SESSION['owner_id']	: 'null';
			//echo "                                   Hed "; exit;
			//echo trim("                                   Hed "); exit;
			
			//var_dump($post);exit;
			//$timestamp = strtotime("26-09-2018");
			//var_dump($timestamp);exit;
			//var_dump($post);exit;
			//var_dump($_SESSION['owner_id']);exit;
			
			$hour			= $post['delivery_time_hour_edit'];
			$minute			= $post['delivery_time_minute_edit'];
			$date_raw 		= $post['delivery_date_edit'];
			//2015-03-26 11:39:59
			$str_date		= $date_raw.' '.$hour.':'.$minute.':00'; //27-09-2018 14:0:00
			//echo $str_date; exit;
			//$date_full 		= new DateTime($str_date);
			$obj_date 		= new DateTime($str_date);;
			$date_formated 	= $obj_date->format('Y-m-d H:i:s');
			//$date_timestamp = strtotime($date_formated);
			//echo strtotime($date_formated); exit;
			//echo date('Y-m-d H:i:s', strtotime($test)); exit;
			//echo $str_date;
			//echo  '</br>';
			//echo strtotime($str_date);exit;
			//echo date('Y-m-d', strtotime($str_date)); exit;
			//--$date_formated 	= $date_full->format('d-m-Y H:i:s');
			//$date_formated 	= $date_full;
			//echo $date->format('d-m-Y');
			//echo $date_formated; exit;


				
			$order_id_edit		= isset($post['order_id_edit']) 				? "'".$post['order_id_edit']."'" 											: 'null';
			$order_code			= isset($post['order_code_edit']) 				? "'".$post['order_code_edit']."'" 											: 'null';
			$customer_name		= isset($post['customer_name_edit']) 			? "'".$post['customer_name_edit']."'"										: 'null';
			$product_type		= isset($post['product_type_edit']) 			? "'".$post['product_type_edit']."'"										: 'null';
			$quantity			= isset($post['quantity_edit']) 			&& $post['quantity_edit'] 		!= "" ? $post['quantity_edit'] 					: 'null';
			$set				= isset($post['set_edit']) 					&& $post['set_edit'] 			!= "" ? $post['set_edit'] 						: 'null';
			$vial				= isset($post['vial_edit']) 				&& $post['vial_edit'] 			!= "" ? $post['vial_edit'] 						: 'null';
			$total_cell			= isset($post['total_cel_edit']) 			&& $post['total_cel_edit'] 		!= "" ? $post['total_cel_edit'] 				: 'null';
			$package_type		= isset($post['package_type_edit']) 		&& $post['package_type_edit'] 	!= "" ? "'".$post['package_type_edit']."'" 		: 'null';
			//$delivery_time		= isset($post['delivery_date']) 	? strtotime($post['delivery_date']) 	: '';
			$delivery_date_time	= isset($post['delivery_date_edit']) 			? "'".$date_formated."'" 													: 'null';
			$giveaway			= isset($post['giveaway_edit']) 				? "'".$post['giveaway_edit']."'" 											: 'null';
			$sender				= isset($post['sender_edit']) 					? "'".$post['sender_edit']."'" 												: 'null';
			$receiver			= isset($post['receiver_edit']) 				? "'".$post['receiver_edit']."'" 											: 'null';
			$dealer_person		= isset($post['dealer_person_edit']) 			? "'".$post['dealer_person_edit']."'" 										: 'null';
			$dealer_company		= isset($post['dealer_company_edit']) 			? "'".$post['dealer_company_edit']."'" 										: 'null';
			//$last_update_date 	= isset($post['last_update_date']) 	? $post['last_update_date'] : '';
			$price_rate			= isset($post['price_rate_edit']) 				? "'".$post['price_rate_edit']."'"											: 'null';
			$comment_else		= isset($post['comment_else_edit']) 			? "'".$post['comment_else_edit' ]."'"										: 'null';
			//$is_active			= isset($post['is_active_edit']) 					&& $post['is_active_edit'] 		!= "" ? $post['is_active_edit'] 		: 'null';
			
			//------------------------------------------------------
			$sta_allow_time_deliv = $this->check_diff_time_by_strtime($delivery_date_time, 300);
			//check time deliv and cell number. or is_staff can be access.
			if(($sta_allow_time_deliv == 1 && $total_cell <= 10)){
				$is_active = true;
			} else {
				$is_active = false;
			}
			//------------------------------------------------------
			$sql = "
				UPDATE order_product SET 
					order_code 				= {$order_code}
					,customer_name 			= {$customer_name}
					,product_type 			= {$product_type}
					,quantity 				= {$quantity}
					,set 					= {$set}
					,vial 					= {$vial}
					,total_cell 			= {$total_cell}
					,package_type 			= {$package_type}
					,delivery_date_time 	= {$delivery_date_time}
					,giveaway 				= {$giveaway}
					,sender 				= {$sender}
					,receiver 				= {$receiver}
					,dealer_person 			= {$dealer_person}
					,dealer_company 		= {$dealer_company}
					,user_id 				= {$user_id}

					,last_update_date 		= NOW()
					,price_rate 			= {$price_rate}
					,comment_else 			= {$comment_else}
					,is_active 				= {$is_active}
				WHERE id = {$order_id_edit}
			";
			//				,order_date 			= {$order_date}
			//var_dump($_SESSION['owner_id']);exit;
	//echo '<pre>';
	//echo $sql; exit;


			try {
				$sth = $this->db->prepare($sql);
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
			//---------------------------------------------
		}else{ //$sta_allow == 0
			$result['success'] = false;
			return json_encode($result);
		}
    }
	//---------------------------------------------------------------------------------------------------------------------------------
	public function updateOrder_bc($post)
    {

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
			and delivery_date_time >= now()::date
			order by delivery_date_time
        ";
		//--and is_active IS true
		//and delivery_date_time >= now()
		//now()::date
        //echo "<pre>", $sql; exit;
        $sth = $this->db->prepare($sql);  //sql2
        $result = array();
        if (!$sth->execute()) {
            echo '<pre>'.$sql;
            print_r($sth->errorInfo());
        } else {
			$get_num_row = $sth->rowCount();
            //var_dump($sth->rowCount()); exit;
            //$result = $sth->fetchObject();
			if($get_num_row > 0){
				$rs = $sth->fetchAll(PDO::FETCH_ASSOC);
				
				$result["success"] = true;
				$result["data"] = $rs;
				return ($result);
			} else {
				//echo 'xxxxxxxxxxxx'; exit;
				$result["success"] = false;
				//echo $result; exit;
				return ($result);
			}
        }
    }
    //-----------------------------------------------------------------
    public function getOrderAll ()
    {
        $sql ="
            select 
				*
            from order_product
			where 1=1
			and delivery_date_time >= now()::date
			and is_active IS true
			order by delivery_date_time
        ";
		//and delivery_date_time >= now()
		//now()::date
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
				$rs = $sth->fetchAll(PDO::FETCH_ASSOC);
				$result["success"] = true;
				$result["data"] = $rs;
				return ($result);
			} else {
				$result["success"] = false;
				return ($result);
			}
        }
    }
    //---------------------------------------------------------
    //-----------------------------------------------------------------
    public function getOrderStaff ()
    {
        $sql ="
            select 
				*
            from order_product
			where 1=1
			and delivery_date_time >= now()::date
			order by delivery_date_time
        ";
		//and is_active IS true
		//and delivery_date_time >= now()
		//now()::date
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
				$rs = $sth->fetchAll(PDO::FETCH_ASSOC);
				$result["success"] = true;
				$result["data"] = $rs;
				return ($result);
			} else {
				$result["success"] = false;
				return ($result);
			}
        }
    }
    //---------------------------------------------------------
    //-----------------------------------------------------------------
    public function getOrderExport ($str_date_start, $str_date_end)
    {
        $sql ="
            select 
				*
            from order_product
			where 1=1
			
			and 	
				delivery_date_time 
				BETWEEN '{$str_date_start}'::timestamp AND '{$str_date_end}'::timestamp
			
        ";
		if($_SESSION['is_staff']){
			//--> nothing act.
		} else {
			$sql .=" and user_id = '{$_SESSION['owner_id']}'";
		}
		$sql .=" and is_active = true";
		$sql .=" order by delivery_date_time";
		//and delivery_date_time >= now()
		//now()::date
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
				$rs = $sth->fetchAll(PDO::FETCH_ASSOC);
				$result["success"] = true;
				$result["data"] = $rs;
				return ($result);
			} else {
				$result["success"] = false;
				return ($result);
			}
        }
    }
    //---------------------------------------------------------
	public function check_diff_time_by_strtime($str_time, $diff_minute){

		$sql = "
			select
			CASE
			  WHEN ((now() + interval '{$diff_minute} minutes') < ({$str_time})::timestamp ) THEN 1
			  ELSE 0
			 END AS sta_allow
		";
 
		
		//--hours
		//select (now() + interval '5 minutes')as x
		//select '2018-10-18 16:40:00'::timestamp  - interval '5 minutes'
		//-------------------------------------------------------------------------------------------------------------------
		//echo "<pre>", $sql; exit;
		$sp = $this->db->prepare($sql);
		$sp->execute();
        if (!$sp->execute()) {
            echo '<pre>'.$sql;
            print_r($sp->errorInfo());
        } else {
			$get_num_row = $sp->rowCount();
			if($get_num_row > 0){
				$rs = $sp->fetchAll(PDO::FETCH_ASSOC);
				//var_dump($rs[0]['sta_allow']);
				return $rs[0]['sta_allow'];

			} else {
				echo "555 error.";
			}
        }
	}
	//---------------------------------------------------------
	public function check_diff_time_by_id($id_product, $diff_minute){

		$sql = "
			select
			CASE
			  WHEN ((now() + interval '{$diff_minute} minutes') < (select delivery_date_time from order_product WHERE id = {$id_product})::timestamp ) THEN 1
			  ELSE 0
			 END AS sta_allow
		";
 
		
		//--hours
		//select (now() + interval '5 minutes')as x
		//select '2018-10-18 16:40:00'::timestamp  - interval '5 minutes'
		//-------------------------------------------------------------------------------------------------------------------
		//echo "<pre>", $sql; exit;
		$sp = $this->db->prepare($sql);
		$sp->execute();
        if (!$sp->execute()) {
            echo '<pre>'.$sql;
            print_r($sp->errorInfo());
        } else {
			$get_num_row = $sp->rowCount();
			if($get_num_row > 0){
				$rs = $sp->fetchAll(PDO::FETCH_ASSOC);
				//var_dump($rs[0]['sta_allow']);
				return $rs[0]['sta_allow'];

			} else {
				echo "555 error.";
			}
        }
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