<?php
/**************************************
 * Class name  : Staticmap.class.php  *
 * Last Modify : Nov 2012             *
 * By          : Narong Rammanee      *
 * E-mail      : ranarong@live.com    *
 **************************************/

class Staticmap extends DBConnection
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
    public function getCenter($id=null)
    {
        $strSQL = "
            SELECT
                way_id,
                ST_AsText(ST_Transform(ST_Centroid(the_geom), 4326)) AS center
            FROM 
                gis_road_masterplan 
            WHERE 
                way_id={$this->id}
        ";

        $result = $this->db->query($strSQL)->fetchObject();

        $center = null;
        if ($result->center !== null) {
            $center = str_replace(')', '', str_replace('POINT(', '', $result->center));

            $center = '&amp;center=' . join(',', self::swap($center));
        }

        return $center;
    }

    public function getPath($id=null)
    {
        $strSQL = "
            SELECT 
                ST_AsText(ST_Transform(the_geom, 4326)) as line
            FROM (
                SELECT
                    ST_NumGeometries(the_geom) AS gnum, 
                    (ST_Dump(the_geom)).geom AS the_geom
                FROM 
                        gis_road_masterplan
                WHERE way_id ={$this->id}
            ) AS t
        ";

        $result = $this->db->query($strSQL);

        $paths = array();
        $i = 0;
        while($row = $result->fetchObject()) {

            $line_str = str_replace(')', '', str_replace('LINESTRING(', '', $row->line));

            $line_arr = explode(',', $line_str);

            foreach ($line_arr as $k => $v) {
                $point[] = self::swap($v);
            }

            $paths[$i++] = $point;
            unset($point);
        }

        return $paths;
    }

	public function getColor($id=null)
    {
		$strSQL = "
            SELECT mp.mp_status      
			FROM way LEFT JOIN master_plan mp ON way.way_id = mp.way_id
			WHERE way.way_id = {$this->id}
			LIMIT 1
        ";

        $result = $this->db->query($strSQL)->fetchObject();

		return $result->mp_status == 'y' ? '0x7800a0A0' : '0xF9F96bA0';
	}

    public function swap($str) {
        $tmp_arr = explode(' ', $str);
        $tmp = $tmp_arr[0];
        $tmp_arr[0] = $tmp_arr[1];
        $tmp_arr[1] = $tmp;

        return $tmp_arr;
    }

    /**
     * file_get_contents_curl
     * 
     * @return data.
     */
    public function file_get_contents_curl($url) {
        /*$ch = curl_init();

		curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);       

		$data = curl_exec($ch);
		curl_close($ch);

		return $data;*/

		curl_setopt($ch=curl_init(), CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		curl_close($ch);
		
		return $response;
    }

	public function save_image($inPath, $outPath){
		//Download images from remote server
		$in  =  fopen($inPath, "rb");
		$out =  fopen($outPath, "wb");

		while ($chunk = fread($in,8192)) {
			fwrite($out, $chunk, 8192);
		}

		fclose($in);
		fclose($out);
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
