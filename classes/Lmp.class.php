<?php
/***********************************
 | Class name  : Cld.class.php     |
 | Last Modify : Sep 2012          |
 | By          : Narong Rammanee   |
 | E-mail      : ranarong@live.c   |
 ***********************************/

class Lmp extends DBConnection
{
    /**
     * Constructor
     */
    public function __construct($pdo=null) 
    {
        parent::__construct($pdo);
    }

//----------------------------------------------------------------------------------------------
    public function getBoundTransfer($id_track, $province_short, $layer_type)
    {

        $sql = "
            SELECT 
                ST_Astext(ST_Transform(ST_Expand(ST_Envelope(the_geom), 1000),900913)) AS bounds
            FROM
                lmp_{$province_short}_{$layer_type}
            WHERE 1=1
            and id_track::int = {$id_track}
        ";
		// echo '<pre>';
		// echo $sql;
		// echo exit;
		
        $sth = $this->db->prepare($sql);
        if (!$sth->execute()) {
            echo $sql;
            print_r($sth->errorInfo());
        } else {
//             $result = array(
//                 "success"                   => true
//             );

            $result= $sth->fetchAll(PDO::FETCH_CLASS);
            //$result["total"] = count($result["items"]);
            return  $result;
        }
    }
	//-----------------------------------------------------------------------------------------------
    public function getBoundTransferNormal($province_id, $survey_id, $layer_type)
    {
		//--> get short name by "province_id".
		$obj_provinces_key_province_id = $this->getProvinces_key_provice_id();
		//var_dump($obj_provinces_key_province_id[$province_id]);exit;
		$short_name = $obj_provinces_key_province_id[$province_id][0]; //arr index 0 is short_name.
		//var_dump($short_name);exit;
		//echo "lmp_{$short_name}_{$layer_type}"; exit;
		
        $sql = "
            SELECT 
				'{$short_name}' as short_name
                ,ST_Astext(ST_Transform(ST_Expand(ST_Envelope(the_geom), 1000),900913)) AS bounds
            FROM
                lmp_{$short_name}_{$layer_type}
            WHERE 1=1
            and id_track::int = {$survey_id}
        ";
		 //echo '<pre>';
		 //echo $sql;
		//exit;
		
        $sth = $this->db->prepare($sql);
        if (!$sth->execute()) {
            echo $sql;
            print_r($sth->errorInfo());
        } else {
            $result= $sth->fetchAll(PDO::FETCH_CLASS);
            //--$result["total"] = count($result["items"]);
            return  $result;
        }
    }
	//-----------------------------------------------------------------------------------------------
    public function getProvinces_key_provice_id ()
    {
        $db_pro = DB_LINK_PROVINCE; //DB_LMP
		$sql = "
		        SELECT 
                    short_name,
					province_id,
                    province_name
                    
                FROM province
                WHERE 1=1
				AND short_name IS NOT NULL 
				ORDER BY province_name
		";
         //echo '<pre>', $sql;exit;
//         var_dump(DSN_INTEGRATION);
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $key => $value) {
            //echo '<br />', $value['short_name'];
            $provinces[$value['province_id']] = array($value['short_name'] , $value['province_id'], $value['province_name']);
        }

        return $provinces;
    }
    //---------------------------------------------------------------------------
    public function getDataIdentTrackTransfer($survey_id, $province_id, $province_short, $layer_type)
    {
		$sql = "xxxxxxxx";
		$db_pro = DB_CLD_LINK;
		function sql12($tb_transfer, $db_pro, $province_id, $survey_id, $province_short, $layer_type) {
			$sql = "
				SELECT tb_cld_transfer.*,ST_Length(track.the_geom)as length
				FROM dblink(
				'{$db_pro}',
				'
					SELECT 
						id_track
						, way_name
						, province_id
						, sum_distance_from_track
						, distance_total
						, survay_date
					FROM {$tb_transfer}
					where province_id = {$province_id}
					and id_track = ''{$survey_id}''
				' 
				) 
				AS tb_cld_transfer(id_track varchar(20),way_name varchar(500),province_id varchar(20),sum_distance_from_track varchar(20),distance_total varchar(20),survay_date varchar(20))
				inner join {$province_short}_".$layer_type."_track track on track.id_track =tb_cld_transfer.id_track
			";
			return $sql;
		}
		//----------------------------------------
		function sql3($tb_transfer, $db_pro, $province_id, $survey_id, $province_short, $layer_type) {
			$sql = "
				SELECT tb_cld_transfer.*,ST_Length(track.the_geom)as length
				FROM dblink(
				'{$db_pro}',
				'
					SELECT 
						fd.id_track
						, fd.way_name
						, pro.province_id
						, distance_tracking as sum_distance_from_track
						, distance_account as distance_total
						, '''' as survay_date

						
					FROM {$tb_transfer} fd
					inner join org_comunity org ON org.orgc_id = fd.orgc_id
					inner join amphur amp ON amp.amphur_id = org.amphur_id 
					inner join province pro ON pro.province_id = amp.province_id
					where pro.province_id = {$province_id}
					and fd.id_track = ''{$survey_id}''

				' 
				) 
				AS tb_cld_transfer(id_track varchar(20),way_name varchar(500),province_id varchar(20),sum_distance_from_track varchar(20),distance_total varchar(20),survay_date varchar(20))
				inner join {$province_short}_".$layer_type."_track track on track.id_track =tb_cld_transfer.id_track
			";
			return $sql;
		}
		//----------------------------------------
		if($layer_type == "transfer"){
			$tb_transfer = "way_transfer";
			$sql =sql12($tb_transfer, $db_pro, $province_id, $survey_id, $province_short, $layer_type);
		} else if ($layer_type == "transfer_incomplete"){
			$tb_transfer = "incomplete_transfer";
			$sql =sql12($tb_transfer, $db_pro, $province_id, $survey_id, $province_short, $layer_type);
		} else if ($layer_type == "transfer_other") {
			$tb_transfer = "fieldbook";
			$sql =sql3($tb_transfer, $db_pro, $province_id, $survey_id, $province_short, $layer_type);
		}
        

 //echo '<pre>';
	//echo $sql;exit;
        $sth = $this->db->prepare($sql);
        if (!$sth->execute()) {
			echo '<pre>';
            echo $sql;
			echo '</pre>';
            print_r($sth->errorInfo());
        } else {
//             $result = array(
//                 "success"                   => true
//             );

            $result= $sth->fetchAll(PDO::FETCH_CLASS);
            //$result["total"] = count($result["items"]);
			$count_rs = count($result);
			if($count_rs <= 0){
				echo "query data is null and you should check sql.";
				echo '<pre>';
				//--echo $sql;
				echo '</pre>';
			}
            return  $result;
        }
    }
//----------------------------------------------------------------------------------------------

    public function getDataIdentTransfer($survey_id, $province_id, $province_short, $layer_type)
    {
		$sql = "xxxxxxxx";
		$db_pro = DB_CLD_LINK;
		function sql12($tb_transfer, $db_pro, $province_id, $survey_id, $province_short, $lmp_type) {
			$sql = "
				SELECT tb.*,ST_Length(lmp.the_geom)as length
				FROM dblink(
				'{$db_pro}',
				'
					SELECT 
						id_track
						, distance_total
						, sum_distance_from_track
						, survay_date
						, way_name
						, orgc_name
						, amphur_name
						
					FROM {$tb_transfer}
					where province_id = {$province_id}
					and id_track = ''{$survey_id}''
				' 
				) 
				AS tb (id_track varchar(20), distance_total varchar(20),sum_distance_from_track varchar(100),survay_date varchar(50),way_name varchar(200),orgc_name varchar(100),amphur_name varchar(100))
			inner join lmp_{$province_short}_{$lmp_type} lmp on lmp.id_track =tb.id_track
			";

			return $sql;
		}
		//----------------------------------------
		function sql3($tb_transfer, $db_pro, $province_id, $survey_id, $province_short, $lmp_type) {
			$sql = "
				SELECT tb.*,ST_Length(lmp.the_geom)as length
				FROM dblink(
				'{$db_pro}',
				'
					SELECT 
						id_track
						, distance_account as distance_total
						, distance_tracking as sum_distance_from_track
						, '''' as survay_date
						, way_name
						, org.orgc_name
						, amp.amphur_name
						
					FROM {$tb_transfer} fd
					inner join org_comunity org ON org.orgc_id = fd.orgc_id
					inner join amphur amp ON amp.amphur_id = org.amphur_id 
					inner join province pro ON pro.province_id = amp.province_id
					where pro.province_id = {$province_id}
					and fd.id_track = ''{$survey_id}''
					
				' 
				) 
				AS tb (id_track varchar(20), distance_total varchar(20),sum_distance_from_track varchar(100),survay_date varchar(50),way_name varchar(200),orgc_name varchar(100),amphur_name varchar(100))
			inner join lmp_{$province_short}_{$lmp_type} lmp on lmp.id_track =tb.id_track
			";
			return $sql;
		}
		//----------------------------------------
		if($layer_type == "transfer"){
			$tb_transfer = "way_transfer";
			$lmp_type = "transfer";
			$sql = sql12($tb_transfer, $db_pro, $province_id, $survey_id, $province_short, $lmp_type);
		} else if ($layer_type == "transfer_incomplete"){
			$tb_transfer = "incomplete_transfer";
			$lmp_type = "transfer_incomplete";
			$sql = sql12($tb_transfer, $db_pro, $province_id, $survey_id, $province_short, $lmp_type);
		} else if ($layer_type == "transfer_other") {
			$tb_transfer = "fieldbook";
			$lmp_type = "transfer_other";
			$sql = sql3($tb_transfer, $db_pro, $province_id, $survey_id, $province_short, $lmp_type);
		}
		

//echo '<pre>';
//echo $sql;exit;

        $sth = $this->db->prepare($sql);
        if (!$sth->execute()) {
            echo $sql;
            print_r($sth->errorInfo());
        } else {
//             $result = array(
//                 "success"                   => true
//             );

            $result= $sth->fetchAll(PDO::FETCH_CLASS);
            //$result["total"] = count($result["items"]);
			
			$count_rs = count($result);
			
			if($count_rs <= 0){
				var_dump($result);
				echo "count_rs : ".$count_rs;
				echo '<pre>';
				echo "please check sql.";
				exit;
			}
            return  $result;
        }
    }

//----------------------------------------------------------------------------------------------

    public function getBoundBridgeTransfer_old($province_id, $survery_id, $km_begin)
    {
		//echo "getBoundBridgeTransfer";
        $sql = "
            SELECT 
                ST_Astext(ST_Transform(ST_Expand(ST_Envelope(the_geom), 500),900913)) AS bounds
            FROM
                lmp_bridge
            WHERE 1=1
            and prov_code = '{$province_id}'
			and survey = '{$survery_id}'
			and km_begin = '{$km_begin}'
        ";
		//echo '<pre>'.$sql; exit;
        $sth = $this->db->prepare($sql);
        if (!$sth->execute()) {
            echo $sql;
            print_r($sth->errorInfo());
        } else {
//             $result = array(
//                 "success"                   => true
//             );

            $result= $sth->fetchAll(PDO::FETCH_CLASS);
            //$result["total"] = count($result["items"]);
			//echo count($result);
			if (count($result) <= 0 ){
				return  false;
			}
            return  $result;
        }
    }

//----------------------------------------------------------------------------------------------
    public function getBoundBridgeTransfer($bridge_transfer_id, $layer_type)
    {
		//--> set defaulf to lmp_bridge.
		if($layer_type != ''){
			if($layer_type != 'transfer'){
				$layer_type ="lmp_bridge";
			} else if($layer_type != 'transfer_incomplete'){
				$layer_type ="lmp_bridge_incomplete";
			}
			
		}
        $sql = "
            SELECT 
                ST_Astext(ST_Transform(ST_Expand(ST_Envelope(the_geom), 500),900913)) AS bounds
            FROM
                {$layer_type}
            WHERE 1=1
            and bridge_id = '{$bridge_transfer_id}'
        ";
		//echo '<pre>'.$sql; exit;
        $sth = $this->db->prepare($sql);
        if (!$sth->execute()) {
            echo $sql;
            print_r($sth->errorInfo());
        } else {
            $result= $sth->fetchAll(PDO::FETCH_CLASS);
			if (count($result) <= 0 ){
				return  false;
			}
            return  $result;
        }
    }
	//----------------------------------------------------------------------------------------------
	
//     public function get_province_all()
//     {
//     //--> no use
//         $db_pro = DB_CLD_LINK;
//         $sql_p ="
//             SELECT x.* 
//             FROM dblink('{$db_pro}',
//                         '
//                         SELECT 
//                             province_id
//                             ,short_name
//                             ,province_name
//                         FROM province
//                         ORDER BY province_name
//                         '
//                             ) AS x(province_id INTEGER, short_name TEXT, province_name TEXT) 
//             WHERE x.short_name IS NOT NULL 
//             --LIMIT 1
//         ";
//         //echo $sql_p;exit;
//         $pro_db = $this->db->query($sql_p)->fetchAll(PDO::FETCH_ASSOC);
//         // echo '<pre>'; print_r($sql_p);
//         // exit;
//         foreach ($pro_db as $key => $value) {
//         //     echo '<br />', $value['short_name'];
//             $provinces[$value['province_id']] = array($value['short_name'] , $value['province_name']);
//             
//         }
// 
//         return $provinces;
//     }
//------------------------------------------------------------------------------------------------

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