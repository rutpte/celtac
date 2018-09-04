<?php
/**************************************
 | Class name  : Golbal_init.class.php|
 | Last Modify : May 2012             |
 | By          : rut                  |
 | E-mail      :                      |
 **************************************/

class Golbal_init extends DBConnection
{
    /**
     * Constructor
     */
    public function __construct($pdo=null)
    {
        parent::__construct($pdo);
    }

    //-------------------------------------------------------------------------
    public function getLmpTransferTableName ($type=null)
    {
			//var_dump($type);
        // $sql ="
            // SELECT table_name
            // FROM 
                // information_schema.tables
            // WHERE table_schema='public'
            // AND table_type='BASE TABLE'
            // AND table_name like 'lmp_%'
            // AND table_name like '%_{$type}'
        // ";
		//------------

		if(true){ // use
			$con = "";
			$point_arr = 0;
			if($type == "transfer"){
				$con = " AND substr(table_name, 1 ,4) = 'lmp_'";
				$con .= " AND substring(table_name,char_length(table_name)-7,8) = 'transfer'";
				$point_arr = 1;
			} else if ($type == "transfer_track"){
				$con = " AND substring(table_name,char_length(table_name)-13,14) = 'transfer_track'";
				$point_arr = 0;
			} else if ($type == "transfer_incomplete"){
				$con = " AND substr(table_name, 1 ,4) = 'lmp_'";
				$con .= " AND substring(table_name,char_length(table_name)-18,19) = 'transfer_incomplete'";
				$point_arr = 1;
			} else if ($type == "transfer_incomplete_track"){
				$con .= " AND substring(table_name,char_length(table_name)-24,25) = 'transfer_incomplete_track'";
				$point_arr = 0;
			} else if ($type == "transfer_other"){
				$con = " AND substr(table_name, 1 ,4) = 'lmp_'";
				$con .= " AND substring(table_name,char_length(table_name)-13,14) = 'transfer_other'";
				$point_arr = 1;
			} else if ($type == "transfer_other_track"){
				$con .= " AND substring(table_name,char_length(table_name)-19,20) = 'transfer_other_track'";
				$point_arr = 0;
			}
			//var_dump($con);
			$sql ="
				SELECT table_name
				FROM 
					information_schema.tables
				WHERE table_schema='public'
				AND table_type='BASE TABLE'
				{$con}
			";
		
			// $sql ="
				// SELECT * FROM (
					// SELECT table_name
					// FROM 
						// information_schema.tables
					// WHERE table_schema='public'
					// AND table_type='BASE TABLE'
					// AND table_name like 'lmp_%'
				// ) as x
				// where 1=1
				// AND x.table_name like '%{$type}'
			// ";
		}

		
        //echo "<pre>", $sql; exit;
        $rs = $this->db->prepare($sql);
        $rs->execute();
        
        $data = Array();
        $rs_fet = $rs->fetchAll(PDO::FETCH_ASSOC);
		
		foreach ($rs_fet as $key => $value) {
			//$data[$value['short_name']] =
			$arr = explode("_", $value["table_name"]);
			$data[$arr[$point_arr]] = $value["table_name"];
			//echo '<pre>';
			//var_dump($arr[$point_arr]);
		}
		//exit;
		//echo '<pre>';
		//var_dump($data); exit;
        return json_encode($data);
    }
    //-------------------------------------------------------------------------------------------------------------------------

    public function init_project_data ($pid=null)
    {
        $sql ="xxxxxxxx
        ";
        //echo "<pre>", $sql; exit;
        $sth = $this->db->prepare($sql);  //sql2
        //$result = array();
        if (!$sth->execute()) {
            echo '<pre>'.$sql;
            print_r($sth->errorInfo());
        } else {
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }
//----------------------------------------------------------------------------------------------
    public function get_province_all($key_first)
    {
		/*
        $db_pro = DB_LINK_PROVINCE;
        $sql_p ="
            SELECT x.* 
            FROM dblink('{$db_pro}',
                        '
                        SELECT 
                            province_id
                            ,short_name
                            ,province_name
                        FROM province
                        ORDER BY province_name
                        '
                            ) AS x(province_id INTEGER, short_name TEXT, province_name TEXT) 
            WHERE x.short_name IS NOT NULL 
            --LIMIT 1
        ";
		*/
        $sql_p ="      
			SELECT 
				province_id
				,short_name
				,province_name
			FROM province
			where short_name IS NOT NULL 
			ORDER BY province_name
			
		";
        //echo $sql_p;exit;
        $pro_db = $this->db->query($sql_p)->fetchAll(PDO::FETCH_ASSOC);
        // echo '<pre>'; print_r($sql_p);
        // exit;
        
        foreach ($pro_db as $key => $value) {
        //     echo '<br />', $value['short_name'];
            if ($key_first == 'short_name'){
                $provinces[$value['short_name']] = array($value['province_id'] , $value['province_name']);
            } else if ($key_first == 'province_name'){
                $provinces[$value['province_name']] = array($value['province_id'] , $value['short_name']);
            } else {
                $provinces[$value['province_id']] = array($value['short_name'] , $value['province_name']);
            }
            
            
        }

        return $provinces;
    }
    //--------------------------------------------------------------------------------------------------------
//     public function get_province_track_id()
//     {
//     //--> no use
//         $db_pro = DB_CLD_LINK;
//         $sql_p ="
//             SELECT x.* 
//             FROM dblink('{$db_pro}',
//                         'SELECT 
//                             short_name,
//                             province_name,
//                             phase,
//                             tracking_province_code
//                         FROM province
//                         ORDER BY province_name'
//                             ) AS x(short_name TEXT, province_name TEXT, phase TEXT, tracking_province_code TEXT) 
//             WHERE x.short_name IS NOT NULL 
//             --LIMIT 1
//         ";
//         //echo $sql_p;exit;
//         $pro_db = $this->db->query($sql_p)->fetchAll(PDO::FETCH_ASSOC);
//         // echo '<pre>'; print_r($sql_p);
//         // exit;
//         foreach ($pro_db as $key => $value) {
//         //     echo '<br />', $value['short_name'];
//             $provinces[$value['province_name']] = array($value['tracking_province_code'] , $value['short_name']);
//             
//         }
// 
//         return $provinces;
//     }
//-----------------------------------------------------------
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
