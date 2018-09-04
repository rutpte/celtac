<?php
/*************************************
 | Class name  : Searching.class.php |
 | Last Modify : May 2012            |
 | By          : rut                 |
 | E-mail      :                     |
 *************************************/

class VideoTracking extends DBConnection
{
    private $provinces;
    private $survey_id;
    private $tracking_province_code;
    /**
     * Constructor
     */
    public function __construct($pdo=null, $survey_id, $short_name)
    {
        parent::__construct($pdo);
        $this->short_name = $short_name;
        $this->provinces = $this->getProvinces();

        $this->survey_id = $survey_id;
        $this->tracking_province_code = intval($this->provinces[$this->short_name][0]);
    }

    public function getVideoBySurveyId($limit, $start, $sort, $dir)
    {
//         echo DSN_INTEGRATION;exit;
        $result = array();
         //$link = 'http://' . $_SERVER['HTTP_HOST'] . '/tracking/resources/P' . sprintf("%03d", $this->tracking_province_code) . '/Surveys/S' . sprintf("%03d", $this->survey_id);
        //$link = 'http://mapdb.pte.co.th/video-tracking/resources/P' . sprintf("%03d", $this->tracking_province_code) . '/Surveys/S' . sprintf("%03d", $this->survey_id);
        
        //--$link = 'http://mapdb.pte.co.th/gisDrawing/resources/P' . sprintf("%03d", $this->tracking_province_code) . '/Surveys/S' . sprintf("%03d", $this->survey_id);
        //--> old :: $link = 'http://'. $_SERVER['HTTP_HOST'] .'/gisDrawing/resources/P' . sprintf("%03d", $this->tracking_province_code) . '/Surveys/S' . sprintf("%03d", $this->survey_id);
        $link = 'http://'. HOST_WMS .'/video-tracking/resources/P' . sprintf("%03d", $this->tracking_province_code) . '/Surveys/S' . sprintf("%03d", $this->survey_id);
        
        //$link = 'http://' . $_SERVER['HTTP_HOST'] . VIDEO_PATH_SHORTCUT . '/'. $this->project_id . '/' . $folder_id;
        //'/video-tracking/resources/gisDrawing'
        $sql = "
            SELECT
                vtv.video_id
                , (SELECT tbj.road_name FROM ssk_join tbj WHERE (string_to_array(tbj.id_track, '_'))[1]::INT = vt.survey_id LIMIT 1) AS road_name
                , 'วิดีโอช่วงที่ ' || row_number() OVER (ORDER BY file_name) AS row_num
                , vtv.video_tracking_id
                , '{$link}/' || vtv.file_name AS file_name
                , duration
            FROM video_tracking_video vtv
                LEFT JOIN video_tracking vt on vtv.video_tracking_id = vt.video_tracking_id
            WHERE 1=1
                AND vt.survey_id = {$this->survey_id}
                AND vt.province_code = '{$this->tracking_province_code}'
                order by file_name ASC
            ";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $result['total'] = $sth->rowCount();
        //echo '<pre>', $sql; exit;
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
                vtk.video_tracking_id
                , vtk.track_current_time
                , replace(round(((vtk.current_km)/1000)::numeric, 3)::VARCHAR, '.', '+') as current_km
                , vtk.lat
                , vtk.lon

            FROM video_tracking_track vtk
            LEFT JOIN video_tracking vt on vtk.video_tracking_id = vt.video_tracking_id
            WHERE 1=1
                    AND vt.survey_id = {$this->survey_id}
                    AND vt.province_code = '{$this->tracking_province_code}'
            ORDER BY vtk.track_current_time
        ";
         //echo '<pre>', $sql; exit;
        $sql2 = "
            SELECT
                road_name
            FROM {$this->short_name}_join
            WHERE (string_to_array(id_track, '_'))[1]::INT = '{$this->survey_id}'
            GROUP BY road_name
            LIMIT 1
        ";
//         echo '<pre>', $sql2; exit;
        $result = array();
        $rs = $this->db->query($sql);
        $rs2 = $this->db->query($sql2);
        if ($rs != false) {
            $result['info'] = $rs2->fetch(PDO::FETCH_ASSOC);
            $result['data'] = $rs->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $result['massage'] = $this->db->errorInfo();
            $result['sql'] = $sql;
            $result['response'] = false;
        }

        return $result;
    }

    public function getProvinces ()
    {
        $db_pro = DB_LINK_PROVINCE;
        // $phase = isset($_SESSION['phase']) ? $_SESSION['phase'] : 2;
        // if (isset($_SESSION['all'])) {
            // $phaseCondition = 'AND (phase = 1 OR phase = 2 OR phase = 3)';
        // } else {
            // $phaseCondition = 'AND phase = ' . $phase;
        // }
		
		// {$phaseCondition}

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
		SELECT 
			short_name,
			province_name,
			phase,
			province_id as tracking_province_code
		FROM province
		WHERE short_name IS NOT NULL 
		
		ORDER BY province_name
            
            
        ";
//         echo '<pre>', $sql;exit;
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
