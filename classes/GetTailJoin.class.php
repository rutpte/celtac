<?php
/*************************************
 | Class name  : Searching.class.php |
 | Last Modify : May 2012            |
 | By          : rut                 |
 | E-mail      :                     |
 *************************************/

class GetTailJoin extends DBConnection
{
    /**
     * Constructor
     */
    public function __construct($pdo=null)
    {
        parent::__construct($pdo);
    }

    public function get_item_join ($join_id, $tb_name, $road_name=null)
    {
        $condition = ' "join" = '."'$join_id'";
        $sql = "
            SELECT
                *
            FROM
                {$tb_name}
            where
                {$condition}
        ";

        $sth = $this->db->prepare($sql);
        $sth->execute();

        $result = Array();
        $result["total"] = $sth->rowCount();
        $result["items"] = $sth->fetchAll(PDO::FETCH_ASSOC);
//         echo '<pre>'; print_r($result["items"]);

        $result["tb_name"] = $tb_name;

        if ($result["total"] > 0) {
            $province_arr = explode('_', $tb_name);
            $province = $province_arr[0];
            $way_type = $province_arr[1];

            if ($road_name != null) {
                $integrationCondition = "AND tbj.road_name = '{$road_name}'";
            } else {
                $integrationCondition = "AND tbj.road_name IS NULL";
            }

            $sql = "
                SELECT

                (SELECT
                    COALESCE(round(SUM(ST_Length(ST_Transform(tbj.the_geom,  32647)) / 1000)::numeric, 3),0) AS distance
                FROM
                    {$province}_join tbj
                where
                    tbj.\"join\" = '{$join_id}'
                    $integrationCondition
                GROUP BY tbj.road_name, tbj.\"join\") AS _before

                , (SELECT
                    COALESCE(round(SUM(ST_Length(ST_Transform(tbj.the_geom,  32647)) / 1000)::numeric, 3),0) AS distance
                FROM
                    {$province}_join tbj
                where
                    tbj.\"join\" = '{$join_id}'
                GROUP BY tbj.\"join\") AS integration
            ";
            //echo "OOO => ".$sql;
            $sth = $this->db->prepare($sql);
            $sth->execute();

            $record = $sth->fetch(PDO::FETCH_ASSOC);

            $result["distance"] = array(
                'before' => floatval($record['_before']),
                'integration' => floatval($record['integration'])
            );
        }

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
