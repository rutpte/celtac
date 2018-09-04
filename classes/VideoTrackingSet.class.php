<?php
/*************************************
 | Class name  : Searching.class.php |
 | Last Modify : May 2012            |
 | By          : rut                 |
 | E-mail      :                     |
 *************************************/

class VideoTrackingSet extends DBConnection
{
    private $provinces;
    private $survey_id;
	private $province_id;
	private $layer_type;
    private $tracking_province_code;
    /**
     * Constructor
     */
    public function __construct($pdo=null, $survey_id, $province_id, $layer_type)
    {
        parent::__construct($pdo);
        //--$this->short_name = $province; // i will not use it.
        $this->provinces = $this->getProvinces();
		$this->obj_provinces_key_province_id = $this->getProvinces_key_provice_id();
        $this->survey_id = $survey_id;
		$this->province_id = $province_id;
		$this->layer_type = $layer_type;
		$this->short_name = $this->obj_provinces_key_province_id[$province_id][0]; //arr index 0 is short_name.
        $this->tracking_province_code = intval($this->provinces[$this->short_name][0]);//arr index 0 is province_id.
		
    }

    public function getVideoBySurveyId($limit, $start, $sort, $dir)
    {
		//$host = "http://192.168.157.34";
		//$host = "http://lmp.drr.go.th";
		//$host = "http://".HOST_WMS;
		$host = "http://".HOST_VIDEO;
		//$host = "http://mapdb.pte.co.th";
		//--$host = "http://localhost";
		
        $result = array();
		//--------------------------------------------------------------------------------------------------------------------------------------------------------
		// ****> this is problam in the future.
		//--> path of video(servey) is greater than 3 digit exp. "0001" :: i should replace 0001 before to Int.(0001 = 1)
		$provinve_video_path_digit4 = array(30); 
		//province_id 30 nakonratchasima.
		if (in_array($this->tracking_province_code, $provinve_video_path_digit4)) {
			$link = $host.'/tracking_'.$this->layer_type.'/P' . sprintf("%03d", $this->tracking_province_code) . '/Surveys/' . sprintf("%04d", $this->survey_id);
		} else {
			$link = $host.'/tracking_'.$this->layer_type.'/P' . sprintf("%03d", $this->tracking_province_code) . '/Surveys/' . sprintf("%03d", $this->survey_id);
		}
		//--------------------------------------------------------------------------------------------------------------------------------------------------------
		//$link = 'xxxxxxxxxxxxxxx';
        //$link = 'http://lmp.drr.go.th/tracking_transfer/P' . sprintf("%03d", $this->tracking_province_code) . '/Surveys/' . sprintf("%03d", $this->survey_id);
		
		//--> for test on mapdb path
        //$link = 'http://mapdb.pte.co.th/video-tracking/resources/tracking_transfer/P' . sprintf("%03d", $this->tracking_province_code) . '/Surveys/' . sprintf("%03d", $this->survey_id);
        
		//-->test in localhost
		//D:\ms4w\apps\mlink_test_video_incomplete
		//--$link = 'http://localhost/mlink_test_video_incomplete'.'/P' . sprintf("%03d", $this->tracking_province_code) . '/Surveys/' . sprintf("%03d", $this->survey_id);
		
        $sql = "
            SELECT
                vtv.video_id
                ,(SELECT road_name FROM lmp_{$this->short_name}_".$this->layer_type." WHERE id_track::int = vtv.survey_id LIMIT 1) AS road_name
                , 'วิดีโอช่วงที่ ' || row_number() OVER (ORDER BY file_name) AS row_num
                
                , '{$link}/' || vtv.file_name AS file_name
                , duration
            FROM video_".$this->layer_type."_tracking_video vtv
            WHERE 1=1
				AND vtv.province_id = {$this->province_id}
                AND vtv.survey_id = {$this->survey_id}
                order by file_name ASC
            ";
        //echo '<pre>'; echo $sql;exit;
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $result['total'] = $sth->rowCount();
// //         echo '<pre>', $sql; exit;
        if($sort) {
            $sql .= ' ORDER BY '.$sort;
            $sql .= strtoupper($dir)=='ASC'?' ASC':' DESC';
        }
        $sql .= " LIMIT {$limit} OFFSET {$start}";

        $sth = $this->db->prepare($sql);
        $sth->execute();
        $result['items'] = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getTrackingBySurveyId ()
    {
        $sql = "
            SELECT
				vtk.track_current_time
                , replace(round(((vtk.current_km)/1000)::numeric, 3)::VARCHAR, '.', '+') as current_km
                , vtk.lat
                , vtk.lon

            FROM video_".$this->layer_type."_tracking_track vtk
            WHERE 1=1
					AND vtk.province_id = {$this->province_id}
                    AND vtk.survey_id = {$this->survey_id}
            ORDER BY vtk.track_current_time
        ";
        //echo '<pre>'; echo $sql;exit;
		//-----------------------------------------------------
        $sql2 = "
            SELECT
                road_name
            FROM lmp_{$this->short_name}_".$this->layer_type."
            WHERE id_track = '{$this->survey_id}'
            GROUP BY road_name
            LIMIT 1
        ";
		//lmp_ubn_transfer.
         //echo '<pre>', $sql2; exit;
        $result = array();
		//------------------------------------------------------
		try {
			$rs = $this->db->query($sql);
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			echo "-------------------";
			echo $sql;
		}
		try {
			$rs2 = $this->db->query($sql2);
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
			echo "-------------------";
			echo $sql2;
		}
		//------------------------------------------------------
        //$rs = $this->db->query($sql);
        //$rs2 = $this->db->query($sql2);
        if ($rs != false && $rs2 != false) {
            $result['info'] = $rs2->fetch(PDO::FETCH_ASSOC);
            $result['data'] = $rs->fetchAll(PDO::FETCH_ASSOC);
			
			$count_info = count($result['info']);
			$count_data = count($result['data']);
			
			if($count_info <= 0){
				echo "SQL2 select count <= 0.";
				echo $sql2;
			}
			if($count_data <= 0){
				echo "SQL select count <= 0.";
				echo $sql;
			}
			
        } else {
//             $result['massage'] = $this->db->errorInfo();
//             $result['sql'] = $sql;
//             $result['response'] = false;
            echo '<pre>';
            if($rs == false){
				echo "SQL ERROR.";
                echo $sql;
            }
            if($rs2 == false){
				echo "SQL2 ERROR.";
                echo $sql2;
            }
            print_r($sth->errorInfo());
        }

        return $result;
    }

    public function getProvinces ()
    {
        $db_pro = DB_LINK_PROVINCE; //DB_LMP


        /*$sql ="
            SELECT x.* 
            FROM dblink('{$db_pro}',
                'SELECT 
                    short_name,
                    province_name,
                    phase,
                    province_id
                FROM province
                WHERE 1=1
                
                ORDER BY province_name'
                    ) AS x(short_name TEXT, province_name TEXT, phase TEXT, tracking_province_code TEXT) 
            WHERE x.short_name IS NOT NULL 
            --LIMIT 1
        ";*/
		$sql = "
		        SELECT 
                    short_name,
                    province_name,
                    phase,
                    province_id as tracking_province_code
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
            $provinces[$value['short_name']] = array($value['tracking_province_code'] , $value['short_name']);
        }

        return $provinces;
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
	//-----------------------------------------------------------------------------------------------
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
