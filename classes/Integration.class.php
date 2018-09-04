<?php
/*************************************
 | Class name  : Searching.class.php |
 | Last Modify : May 2012            |
 | By          : rut                 |
 | E-mail      :                     |
 *************************************/

class Integration extends DBConnection
{
    /**
     * Constructor
     */
    public function __construct($pdo=null)
    {
        parent::__construct($pdo);
    }

    public function initSessionProvinces ($phase=null)
    {
        $sql = "
            SELECT
				prv.province_id
                , prv.province_name
                , prv.short_name
				, prv.drop_name
                , prv.phase
                , prv.phase_edit
                , prv.has_track
                , prv.has_video
                , prv.has_transfer
                , prv.hidden_seminar
                , gpr.bounds
            FROM
                province prv LEFT JOIN
                dblink(
                    '" . DB_PROTOPJ_LINK . "',
                    'SELECT pro_code, ST_AsText(ST_Envelope(the_geom)) AS bounds FROM gis_province'
                ) AS gpr(pro_code INT, bounds TEXT) ON  prv.province_id = gpr.pro_code
            WHERE 1=1
                
                AND enabled IS TRUE
                AND province_id < 100
            ORDER BY prv.province_name ASC
        ";

        $sth = $this->db->prepare($sql);
        $sth->execute();
		//echo $sql; exit; 
		
		//--> clear cache browser when it still live after close.
        $_SESSION['provinces'] = $sth->fetchALL(PDO::FETCH_ASSOC);
    }

    public function initWorkspace ()
    {
//         if (isset($_SESSION['phase'])) {
//             if ($_SESSION['phase'] == 1 && $_SESSION['phase_edit'] == 'false') {
//             $_SESSION['gl_workspace'] = '"Integration"';
//             } else if ($phase == 2 && $phase_edit == 'false') {
//                 $jsInit['gl_workspace'] = '"IntegrationII"';
//             } 
//         } else {
//             $_SESSION['gl_workspace'] = '"IntegrationAll"';
//         }

        
    }

    public function getTotal_detail ($join_id, $get4_province, $get4_type) 
    {
        /*if($get4_type = 'province'){
            $colum = 'prov';
        }elseif($get4_type = 'amphoe'){
            $colum = 'amp';
        }elseif($get4_type = 'tambon'){
            $colum = 'tam_pass';
        }elseif($get4_type = 'poi'){
            $colum = 'poi_pass';
        }*/
        //$condition = ($join_id != '' ? " WHERE ".$column." ILIKE '".$query."%'" : null);
        //SELECT * FROM npt_detail_amphoe tb WHERE tb."join"='4127D'
        $condition = " WHERE tb.\"join\"='".$join_id."'";
        $sql = "
        SELECT count(*) 
        FROM {$get4_province}_detail_{$get4_type} tb 
        {$condition}
        
        ";
        //var_dump($sql); exit;
        if($this->db->query($sql)){
            return $this->db->query($sql)->fetchObject()->count;
        }else{
            echo 'canot query : <br>';
            var_dump($sql);
        }
        
    }
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
    public function getTotal_surface ($join_id) 
    {


         $sql = "
            SELECT DISTINCT
                wtk.way_track_id AS id

            FROM way_present wpr 
                INNER JOIN way_track wtk ON wtk.way_track_id = wpr.way_track_id
                INNER JOIN {$province}_track_join_process tjp ON tjp.track_id = wtk.way_track_id
                INNER JOIN {$province}_join tbj ON tbj.\"join\" = tjp.\"join\"
            WHERE tjp.\"join\" = '{$join_id}'

            LIMIT 1
        ";
        //var_dump($sql); exit;
        if($this->db->query($sql)){
            return $this->db->query($sql)->fetchObject()->count;
        }else{
            echo 'canot query : <br>';
            var_dump($sql);
        }

    }
//------------------------------------------------------------------------------
    public function getItems_detail ($join_id, $get4_province, $get4_type, $count)
    {
        if($get4_type == 'province'){
            $colum = 'prov';
            $alias = 'province_name';
        }elseif($get4_type == 'amphoe'){
            $colum = 'amp';
            $alias = 'amphoe_name';
        }elseif($get4_type == 'tambon'){
            $colum = 'tam';
            $alias = 'tambon_name';
        }elseif($get4_type == 'poi'){
            $colum = 'poi';
            $alias = 'poi_name';
        }
        $condition = " WHERE tb.\"join\"='".$join_id."'";
        $sql = "
            SELECT 
                tb.{$colum} AS {$alias}

            FROM 
                {$get4_province}_detail_{$get4_type} tb {$condition}
            GROUP BY tb.{$colum}
        ";
        //echo "<pre>"; var_dump($sql); exit;
        $sth = $this->db->prepare($sql);
        $sth->execute();

        $result = Array();
        //$result["total"] = $count;
        $result["items"] = $sth->fetchAll(PDO::FETCH_CLASS);
        $result["total"] = count($result["items"]);

        return $result;
    }

    public function getSufaceSidwalkByJoin($join,$province)
    {
        $index = self::recursive_array_search($province, $_SESSION['provinces']);
        $province_name = $_SESSION['provinces'][$index]['province_name'];
        $sql = "
            SELECT
                CASE
                    WHEN MIN(surface_lt) < MAX(surface_lt)
                    THEN to_char(MIN(surface_lt)::real, '990D99')::text || ' -' || to_char(MAX(surface_lt)::real, '990D99')
                    ELSE to_char(MIN(surface_lt)::real, '990D99')::text
                END AS surface_lt
                , CASE
                    WHEN MIN(surface_rt) < MAX(surface_rt)
                    THEN to_char(MIN(surface_rt)::real, '990D99')::text || ' -' || to_char(MAX(surface_rt)::real, '990D99')
                    ELSE to_char(MIN(surface_rt)::real, '990D99')::text
                END AS surface_rt
                , CASE
                    WHEN MIN(sidewalk_lt) < MAX(sidewalk_lt)
                    THEN to_char(MIN(sidewalk_lt)::real, '990D99')::text || ' -' || to_char(MAX(sidewalk_lt)::real, '990D99')
                    ELSE to_char(MIN(sidewalk_lt)::real, '990D99')::text
                END AS sidewalk_lt
                , CASE 
                    WHEN MIN(sidewalk_rt) < MAX(sidewalk_rt)
                    THEN to_char(MIN(sidewalk_rt)::real, '990D99')::text || ' -' || to_char(MAX(sidewalk_rt)::real, '990D99')
                    ELSE to_char(MIN(sidewalk_rt)::real, '990D99')::text
                END AS sidewalk_rt
            FROM way_present wpr
                INNER JOIN way_track wtk ON wtk.way_track_id = wpr.way_track_id
                INNER JOIN way_detail wdt ON wdt.way_track_id = wtk.way_track_id
                INNER JOIN {$province}_join tbj ON tbj.id_track = wtk.survey_id
            WHERE
                1 = 1
                AND tbj.\"join\" = '{$join}'
                AND wdt.province = '{$province_name}'
        ";
     //echo '<pre>'; print_r($sql); exit;
        $sth = $this->db->prepare($sql);
        $sth->execute();

        $result["items"] = $sth->fetchAll(PDO::FETCH_CLASS);
        $result["total"] = count($result["items"])>0 ?1:0;
        $result['province_name'] = $province_name;

        return $result;
    }
//------------------------------------------------------------------------------
    public function recursive_array_search($needle,$haystack) {
        foreach($haystack as $key=>$value) {
            $current_key=$key;
            if($needle===$value OR (is_array($value) && self::recursive_array_search($needle,$value) !== false)) {
                return $current_key;
            }
        }
        return false;
    }
//------------------------------------------------------------------------------
    public function get_gid ($join_id, $pro_code, $road_name) 
    {
        $condition = $road_name != '' ? "AND road_name = '{$road_name}'" : '';

        $sql = "
            SELECT
                gid
            FROM
                {$pro_code}_join
            WHERE
                1 = 1
                AND \"join\" = '{$join_id}'
                $condition 
        ";
        // echo '<pre>'; var_dump($sql); exit;
        $sth = $this->db->prepare($sql);
        $sth->execute();

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        if ($result) {
            return $result;
        } else {
            echo 'canot query : <br>';
            var_dump($sql);
        }

    }
//------------------------------------------------------------------------------

//------------------------------------------------------------------------------
    public function startEnd ($join, $shortName, $label) 
    {
        if ($label != '') {
            $condition = "AND tbjse.label = '{$label}'";
        } else {
             $condition = '';
        }
        
        
        
        $sql = "
            SELECT
                tbjse.gid
            FROM
                {$shortName}_join_se tbjse
                LEFT JOIN {$shortName}_join tbj ON tbj.\"join\" = tbjse.\"join\"

            WHERE
                1 = 1
                AND tbj.\"join\" = '{$join}'
                $condition
            GROUP BY tbjse.gid
        ";
        // echo '<pre>'; var_dump($sql); exit;
        $sth = $this->db->prepare($sql);
        $sth->execute();

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);

        return $result;
        

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
