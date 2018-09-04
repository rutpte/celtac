<?php
/*************************************
 | Class name  : Searching.class.php |
 | Last Modify : May 2012            |
 | By          : rut                 |
 | E-mail      :                     |
 *************************************/

class VideoTrackingTransfer extends DBConnection
{
    private $provinces;
    private $survey_id;
    private $tracking_province_code;
	//-----------------------------------------------------------------------------------------------------------
    /**
     * Constructor
     */
    public function __construct($pdo=null, $survey_id, $short_name)
    {
        parent::__construct($pdo);
        $this->short_name = $short_name;
        $this->provinces = $this->getProvinces();
//         echo "<pre>";
//         print_r($this->provinces);
        $this->survey_id = $survey_id;
        $this->tracking_province_code = intval($this->provinces[$this->short_name][0]);
    }
	//-----------------------------------------------------------------------------------------------------------
    public function getVideoBySurveyId($limit, $start, $sort, $dir)
    {
//         echo DSN_INTEGRATION;exit;
        $result = array();
         //$link = 'http://' . $_SERVER['HTTP_HOST'] . '/tracking/resources/P' . sprintf("%03d", $this->tracking_province_code) . '/Surveys/S' . sprintf("%03d", $this->survey_id);
        //$link = 'http://mapdb.pte.co.th/video-tracking/resources/P' . sprintf("%03d", $this->tracking_province_code) . '/Surveys/S' . sprintf("%03d", $this->survey_id);
        
        //--$link = 'http://mapdb.pte.co.th/gisDrawing/resources/P' . sprintf("%03d", $this->tracking_province_code) . '/Surveys/S' . sprintf("%03d", $this->survey_id);
        //$link = 'http://'. $_SERVER['HTTP_HOST'] .'/gisDrawing/resources2/P' . sprintf("%03d", $this->tracking_province_code) . '/Surveys/S' . sprintf("%03d", $this->survey_id);
        
        //--$link = 'http://'. HOST_WMS .'/video-tracking/resources/lmp_tracking_transfer/P' . sprintf("%03d", $this->tracking_province_code) . '/Surveys/' . sprintf("%03d", $this->survey_id);
        
        //----------------------------------------------------------------------------------------------------------------------------------
        //--> real path on custom server
        //--$link = 'http://lmp.drr.go.th/tracking/resources/lmp_transfer_track/P' . sprintf("%03d", $this->tracking_province_code) . '/Surveys/' . sprintf("%03d", $this->survey_id);
        
        //--> for test on mapdb path
        //$link = 'http://mapdb.pte.co.th/video-tracking/resources/tracking_transfer/P' . sprintf("%03d", $this->tracking_province_code) . '/Surveys/' . sprintf("%03d", $this->survey_id);
		
			//--------------------------------------------------------------------------------------------------------------------------------------------------------
			//--> path of video(servey) is greater than 3 digit
			$provinve_video_path_digit4 = array(30); 
			//province_id 30 nakonratchasima.
			if (in_array($this->tracking_province_code, $provinve_video_path_digit4)) {
				$link = 'http://lmp.drr.go.th/tracking_transfer/P' . sprintf("%03d", $this->tracking_province_code) . '/Surveys/' . sprintf("%04d", $this->survey_id);
			} else {
				$link = 'http://lmp.drr.go.th/tracking_transfer/P' . sprintf("%03d", $this->tracking_province_code) . '/Surveys/' . sprintf("%03d", $this->survey_id);
			}
			//--------------------------------------------------------------------------------------------------------------------------------------------------------
        //$link = 'http://lmp.drr.go.th/tracking_transfer/P' . sprintf("%03d", $this->tracking_province_code) . '/Surveys/' . sprintf("%03d", $this->survey_id);
        $sql = "
            SELECT
                vtv.video_id
                --, (SELECT tbj.road_name FROM ssk_join tbj WHERE (string_to_array(tbj.id_track, '_'))[1]::INT = vt.survey_id LIMIT 1) AS road_name
                ,(SELECT road_name FROM lmp_{$this->short_name}_transfer WHERE id_track::int = vt.survey_id LIMIT 1) AS road_name
                , 'วิดีโอช่วงที่ ' || row_number() OVER (ORDER BY file_name) AS row_num
                , vtv.video_tracking_id
                , '{$link}/' || vtv.file_name AS file_name
                , duration
            FROM video_transfer_tracking_video vtv
                LEFT JOIN video_transfer_tracking vt on vtv.video_tracking_id = vt.video_tracking_id
            WHERE 1=1
                AND vt.survey_id = {$this->survey_id}
                AND vt.province_code = '{$this->tracking_province_code}'
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
	//-----------------------------------------------------------------------------------------------------------
    public function getTrackingBySurveyId ()
    {
        $sql = "
            SELECT
                vtk.video_tracking_id
                , vtk.track_current_time
                , replace(round(((vtk.current_km)/1000)::numeric, 3)::VARCHAR, '.', '+') as current_km
                , vtk.lat
                , vtk.lon

            FROM video_transfer_tracking_track vtk
            LEFT JOIN video_transfer_tracking vt on vtk.video_tracking_id = vt.video_tracking_id
            WHERE 1=1
                    AND vt.survey_id = {$this->survey_id}
                    AND vt.province_code = '{$this->tracking_province_code}'
            ORDER BY vtk.track_current_time
        ";
        //echo '<pre>'; echo $sql;exit;

//         $sql2 = "
//             SELECT
//                 road_name
//             FROM {$this->short_name}_join
//             WHERE (string_to_array(id_track, '_'))[1]::INT = '{$this->survey_id}'
//             GROUP BY road_name
//             LIMIT 1
//         ";
        $sql2 = "
            SELECT
                road_name
            FROM lmp_{$this->short_name}_transfer
            WHERE id_track = '{$this->survey_id}'
            GROUP BY road_name
            LIMIT 1
        ";
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
				echo $sql2;
			}
			if($count_data <= 0){
				echo $sql;
			}
			
        } else {
//             $result['massage'] = $this->db->errorInfo();
//             $result['sql'] = $sql;
//             $result['response'] = false;
            echo '<pre>';
            if($rs == false){
                echo $sql;
            }
            if($rs2 == false){
                echo $sql2;
            }
            print_r($sth->errorInfo());
        }

        return $result;
    }
	//-----------------------------------------------------------------------------------------------------------
    public function getProvinces ()
    {
        $db_pro = DB_LINK_PROVINCE;//gis_lmp
        /*$sql ="
            SELECT x.* 
            FROM dblink('{$db_pro}',
                'SELECT 
                    short_name,
                    province_name,
                    phase,
                    --tracking_province_code
                    province_id
                FROM province
                WHERE 1=1
                
                ORDER BY province_name'
                    ) AS x(short_name TEXT, province_name TEXT, phase TEXT, tracking_province_code TEXT) 
            WHERE x.short_name IS NOT NULL 
            --LIMIT 1
        ";*/
        $sql ="
            SSELECT 
                    short_name,
                    province_name,
                    phase,
                    --tracking_province_code
                    province_id
                FROM province
                WHERE short_name IS NOT NULL 
                
                ORDER BY province_name
            
           
        ";
         //echo '<pre>', $sql;exit;
//         var_dump(DSN_INTEGRATION);
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $key => $value) {
//             echo '<br />', $value['short_name'];
            $provinces[$value['short_name']] = array($value['tracking_province_code'] , $value['short_name']);
        }

        return $provinces;
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
