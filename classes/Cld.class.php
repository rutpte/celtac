<?php
/***********************************
 | Class name  : Cld.class.php     |
 | Last Modify : Sep 2012          |
 | By          : Narong Rammanee   |
 | E-mail      : ranarong@live.c   |
 ***********************************/

class Cld extends DBConnection
{
    /**
     * ID
     */
    private $id;

    /**
     * Constructor
     */
    public function __construct($pdo=null, $id=null) 
    {
        parent::__construct($pdo, $id);
        $this->id = $id;
    }

    /**
     * getGeom
     * @param interger id
     */
    public function getGeom($id=null) {
        $sql = "
            SELECT
                way_id AS id,
                ST_Astext(ST_Transform(the_geom,900913)) AS wkt, 
                ST_Astext(ST_Transform(ST_Expand(ST_Envelope(the_geom), 1000),900913)) AS bounds,
                geom_length AS length
            FROM
                gis_road_masterplan
            WHERE
                way_id in({$this->id})
        ";
//echo $sql;
        $result = $this->db->query($sql)->fetchObject();

        return $result;
    }
    public function getStartEnd($id=null) {
        $sql = "
            select 
                trariff_start_road_n
                ,trariff_start_road_e
                ,trariff_end_road_n
                ,trariff_end_road_e 
            from way 
            where way_id in({$this->id})
        ";
//echo $sql;
        $result = $this->db->query($sql)->fetchObject();

        return $result;
    }
    /**
     * getBound
     * @param interger id
     */
    public function getBound()
    {
        $result = array();

        try {
            $sql = "
                SELECT 
                    way_id as id
                    ,ref_province_id as province_id
                    ,ref_amphur_id as amphur_id
                    ,orgc_id as tambon_id
                    ,astext(transform(envelope(tam.the_geom),900913)) AS tbounds
                    ,astext(transform(envelope(amp.the_geom),900913)) AS abounds
                    ,astext(transform(envelope(pro.the_geom),900913)) AS pbounds
                FROM way
                    LEFT JOIN gis_tambon tam ON way.orgc_id = tam.tambon_id
                    LEFT JOIN gis_amphur amp ON way.ref_amphur_id = amp.amp_id
                    LEFT JOIN gis_province pro ON way.ref_province_id = pro.prov_id
                WHERE way_id={$this->id}";
            
            $res = $this->db->query($sql)->fetchObject();

            if ($res->tambon_id && $res->tbounds != null) {
                $bounds = $res->tbounds;
            } else if ($res->amphur_id && $res->abounds != null) {
                $bounds = $res->abounds;
            } else  if ($res->province_id && $res->pbounds != null) {
                $bounds = $res->pbounds;
            }
        } catch (PDOException $e) {
        echo $sql;
            $result = Array(
                "status" => false,
                "message" => $e->getMessage()
            );
        }

        return $bounds;
    }

    /**
     * updateGeometry
     * @param string id
     */
    public function updateGeometry($id, $geometry, $srs, $shapetype)
    {
        $result = array();

        try {
            if ($geometry == "MULTILINESTRING()") {
                //$sql = "UPDATE gis_road_masterplan SET the_geom=null WHERE way_id={$this->id}";
                $sql = "DELETE FROM gis_road_masterplan WHERE way_id={$this->id}";
            } else {
                $sql = "
                    UPDATE gis_road_masterplan SET
                        the_geom = ST_GeomFromEWKT('SRID={$srs};{$geometry}'),
                        geom_length = round((st_length(ST_Transform(ST_GeomFromEWKT('SRID={$srs};{$geometry}'), 4326), true) / 1000)::numeric, 3)
                    WHERE way_id = {$this->id}
                ";
            }

            $res = $this->db->exec($sql);
            if ($res === false) {
                $result = array(
                    "geometry" => $geometry,
                    "sql" => $sql,
                    "status" => false,
                    "message" => $this->db->errorInfo()
                );
            } else {
// if update 0 row
                if ($res === 0) {
                    $sql = "
                        INSERT INTO gis_road_masterplan (
                            way_id,
                            geom_length,
                            the_geom
                        ) VALUES (
                            {$this->id},
                            round((st_length(ST_Transform(ST_GeomFromEWKT('SRID={$srs};{$geometry}'), 4326), true) / 1000)::numeric, 3),
                            ST_GeomFromEWKT('SRID={$srs};{$geometry}')
                        )
                    ";

                    $inRes = $this->db->exec($sql);
                }
                $result = array(
                    "status" => true,
                    "sql" => $sql,
                    "action" => $inRes ? "insert" : "update ".$res." row",
                    "message" => $geometry
                );
            }
        } catch (PDOException $e) {
            $result = Array(
                "status" => false,
                "message" => $e->getMessage()
            );
        }

        return $result;
    }
    
    public function getBoundProvince($province_id)
    {
        $result = array();

        try {
            $sql = "
            SELECT prov_id as province_id
                , pro_name
                ,ST_Astext(ST_Transform(ST_Expand(ST_Envelope(the_geom), 1000),900913)) AS bounds
            FROM
                gis_province pro
            WHERE 1=1
            and prov_id = {$province_id}
        ";
        $bound = $res = $this->db->query($sql)->fetchObject();
        $result = array(
                    "status" => true,
                    "items" => $bound,
                    "sql" => $sql
                );
        }catch (PDOException $e) {
            $result = Array(
                "status" => false,
                "message" => $e->getMessage()
            );
        }
        return $result;
    }
//----------------------------------------------------------------------------------------------
    public function getLonLatPoint ($id_track, $province_short)
    {

        ///-----------------
        try {
            $strSQL = "
                SELECT
                    st_extent(ST_Expand(the_geom,500)) AS bounds
                FROM lmp_{$province_short}_transfer
                WHERE 1 = 1
                and id_track in ('{$id_track}')
            ";
     //echo '<pre>', $strSQL;exit;
            $result = $this->db->prepare($strSQL);
            $state = $result->execute();
            $result = $result->fetchObject();
            $rs = array();
            if ( $result ) {
                //echo $result;
                $rs = array(
                    'rs'  => true,
                    'data'      => $result,
                );
            }else{
                $rs = array('rs'        => false);
            }
        } catch (Exception $e) {
            echo "getLonLatPoint fail (drawingClass.php:1028) : " . $e->getMessage();
        }
        return $rs;
    }
    //---------------------------------------------------------------------------------
    /*
    public function getLonLatPoint($survey_id, $province_code, $province_short)
    {
        $db_pro = DB_CLD_LINK;
        $sql = "
            SELECT way_transfer.the_geom
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
                FROM way_transfer
                where province_id = {$province_code}
                and id_track = ''{$survey_id}''
            ' 
            ) 
            AS way_transfer(id_track varchar(20),way_name varchar(100),province_id varchar(20),sum_distance_from_track varchar(20),distance_total varchar(20),survay_date varchar(20))
            inner join {$province_short}_transfer_track track on track.id_track =way_transfer.id_track
        ";
// echo '<pre>';
// echo $sql;exit;
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
    } */
//----------------------------------------------------------------------------------------------
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