<?php
/*************************************
 | Class name  : Searching.class.php |
 | Last Modify : May 2012            |
 | By          : Narong Rammanee     |
 | E-mail      : ranarong@live.com   |
 *************************************/

class Searching extends DBConnection
{
    /**
     * Constructor
     */
    public function __construct($pdo=null)
    {
        parent::__construct($pdo);
    }

    /**
     * getTotal
     * @param string table name
     * @param string query string
     * @param string column name
     */
    public function getTotal ($table, $query, $column) 
    {
        $condition = ($query != '' ? " WHERE ".$column." ILIKE '".$query."%'" : null);
        $strSQL = "SELECT count(*) FROM {$table} {$condition}";
//         var_dump($strSQL); exit;
        return $this->db->query($strSQL)->fetchObject()->count;
    }

     /**
     * getTotal
     * @param string table name
     * @param string query string
     * @param string column name
     * @param string limit
     * @param string start
     * @param string sort
     * @param string dir
     */
    public function getPosition ($table, $query, $column, $limit, $start, $sort, $dir)
    {
        $strSQL = "
            SELECT 
                gid, 
                {$column} as text,
                ST_Astext(
                    ST_Envelope(
                        ST_Transform(the_geom,900913)
                    )
                ) as position 
            FROM 
                {$table}";
        if($query != "") {
            $strSQL .= ' WHERE '.$column.' like :query';
        }
        if($sort) {
            $strSQL .= ' ORDER BY '.$sort;
            $strSQL .= strtoupper($dir)=='ASC'?' ASC':' DESC';
        }
        $strSQL .= ' LIMIT :limit OFFSET :start;';

        $sth = $this->db->prepare($strSQL);
        $sth->bindValue(':query', $query.'%');
        $sth->bindValue(':limit', $limit);
        $sth->bindValue(':start', $start);
        $sth->execute();

        $result = Array();
        $result["total"] = self::getTotal ($table, $query, $column);
        $result["items"] = $sth->fetchAll(PDO::FETCH_CLASS);

        return $result;
    }

    /**
     * Google search API
     * @param string query string
     * @param string limit
     * @param string start
     * @param string sort
     * @param string dir
     */
    public function google ($query, $limit, $start, $sort, $dir) {
        $content = file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($query)."&sensor=false&language=th");

        if ($content !== FALSE) {
            $content = json_decode($content);
            $result = Array();
            $result["total"] = count($content->results);
            $result["items"] = Array();
            $count = 1;
            $list = array_slice($content->results, $start, $limit);
            foreach ($list as $item) {
                if (isset($item->geometry->bounds)) {
                    $minx = $item->geometry->bounds->southwest->lng;
                    $miny = $item->geometry->bounds->southwest->lat;
                    $maxx = $item->geometry->bounds->northeast->lng;
                    $maxy = $item->geometry->bounds->northeast->lat;

                    $position = 'POLYGON(('.
                        $minx.' '.$miny.','.
                        $maxx.' '.$miny.','.
                        $maxx.' '.$maxy.','.
                        $minx.' '.$maxy.','.
                        $minx.' '.$miny.
                    '))';

                    $strSQL = "
                        SELECT 
                            ST_AsText(
                                ST_Transform(
                                    ST_GeomFromText('SRID=4326;{$position}'),
                                    900913
                                )
                           ) As bounds;";

                    $bounds = $this->db->query($strSQL)->fetchObject()->bounds;
                    array_push(
                        $result["items"],
                        Array(
                            "gid" => $count++,
                            "text" => $item->formatted_address,
                            "position" => $bounds
                        )
                    );
                }
                else {
                    $x = $item->geometry->location->lng;
                    $y = $item->geometry->location->lat;

                    $strSQL = "
                        SELECT 
                            ST_AsText(
                                ST_Expand(
                                    ST_Transform(
                                        ST_GeomFromText('SRID=4326;POINT({$x} {$y})'),
                                        900913
                                    ),
                                    100
                                )
                           ) As bounds;";
                    $bounds = $this->db->query($strSQL)->fetchObject()->bounds;
                    array_push(
                        $result["items"],
                        Array(
                            "gid" => $count++,
                            "text" => $item->formatted_address,
                            "position" => $bounds
                        )
                    );
                }
            }

            return json_encode($result);
        }
        return '{"total":0,"items":[]}';
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
