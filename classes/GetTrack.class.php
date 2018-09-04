<?php
/*************************************
 | Class name  : Searching.class.php |
 | Last Modify : May 2012            |
 | By          : rut                 |
 | E-mail      :                     |
 *************************************/

class GetTrack extends DBConnection
{
    /**
     * Constructor
     */
    public function __construct($pdo=null)
    {
        parent::__construct($pdo);
    }
//------------------------------------------------------------------------------
    public function get_track ($survey_id, $pro_code, $baseTime=null)
    {

                $f = 0;
                $t = 0;
                //echo 'baset = '.$baseTime;
                       $strSQL = " select tk.id,tk.a_time,tk.b_time,tk.lat,tk.long,tk.km_id,
                        replace(round(((tk.cur_km+kb.km)/1000)::numeric, 3)::VARCHAR, '.', '+') as cur_km

                        from tracking tk
                        left join km_begin kb on kb.id = tk.km_id 
                        where 1=1 
                        and kb.survey_id = {$survey_id} 
                        and kb.pro_code = '{$pro_code}'
                         ";
                        if($baseTime){
							$strSQL .= "and to_timestamp(a_time, 'DD MM YYYY HH24:MI:SS') >= to_timestamp('{$baseTime}', 'DD MM YYYY HH24:MI:SS')";
                            /*
							$strSQL .= "and (to_timestamp(a_time, 'DD MM YYYY HH24:MI:SS') >= to_timestamp('{$baseTime}', 'DD MM YYYY HH24:MI:SS')";
                            $strSQL .= "or tk.id >= (
                                select id from tracking
                                where to_timestamp(a_time, 'DD MM YYYY HH24:MI:SS') >= to_timestamp('{$baseTime}', 'DD MM YYYY HH24:MI:SS')
                                and km_id =    (
                                    select id from km_begin
                                    where pro_code = '{$pro_code}'
                                    and survey_id = {$survey_id}
                                    )
                                limit 1
                                    ))
                                ";*/
                        }
                        $strSQL .="order by a_time";
                        //echo '<pre>'; echo $strSQL; echo '</pre>'; exit;

        
                if($rs = $this->db->query($strSQL)){
                        $t++;
                }else{
                        $f++;
                }
//                 var_dump($rs);exit;
                $success = array();
                if($f >= 1){
                        $success['massage'] = $this->db->errorInfo();
                        $success['sql'] = $strSQL;
                        $success['response'] = false;
                        return $success;
                }else{
                        $success['response'] = true;
                        $success['data'] = $rs->fetchAll(PDO::FETCH_ASSOC);
                        return $success;
                }
        
    }
	//-----------------------------------------------------------------------------------------------
    public function get_provine_hastrack ($db_pro)
    {
        $f = 0;
        $t = 0;
		$strSQL = "
		SELECT x.*
        FROM dblink('{$db_pro}','
			SELECT short_name FROM province 
			WHERE has_track IS TRUE
			')
        AS x(province_name TEXT)
		";
		if($rs = $this->db->query($strSQL)){
				$t++;
		}else{
				$f++;
		}
//                 var_dump($rs);exit;
		$success = array();
		if($f >= 1){
				$success['massage'] = $this->db->errorInfo();
				$success['sql'] = $strSQL;
				$success['response'] = false;
				return $success;
		}else{
				$success['response'] = true;
				$success['data'] = $rs->fetchAll(PDO::FETCH_ASSOC);
				return $success;
		}
	}

   
//------------------------------------------------------------------------------
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
