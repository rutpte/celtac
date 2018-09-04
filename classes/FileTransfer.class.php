<?php
/****************************************
 * Class name  : FileTransfer.class.php *
 * Last Modify : Sep 2012               *
 * By          : Narong Rammanee        *
 * E-mail      : ranarong@live.com      *
 ****************************************/

class FileTransfer extends DBConnection
{
    private $project = array();

    public function __construct($file=array(), $post=array(), $temp_file, $road_zip_path) 
    {
        parent::__construct();

        $this->id = $post['id'];
        $this->srs = $post['srs'];

        $this->type = $file['uploadfile']['type'];
        $this->temp = $file['uploadfile']['tmp_name'];
        $this->name = $file['uploadfile']['name'];
        $this->temp_file = $temp_file;
        $this->road_zip_path = $road_zip_path;

        $this->project = array(
            "32647"  => ms_newprojectionobj("init=epsg:32647"),
            "32648"  => ms_newprojectionobj("init=epsg:32648"),
            "24047"  => ms_newprojectionobj("init=epsg:24047"),
            "24048"  => ms_newprojectionobj("init=epsg:24048"),
            "4326"   => ms_newprojectionobj("init=epsg:4326"),
            "900913" => ms_newprojectionobj("init=epsg:900913"),
			"3857" => ms_newprojectionobj("init=epsg:3857")
        );
    }

    public function extractZip($zipfile, $extract_path)
    {
        $zip = new ZipArchive;
        $res = $zip->open($zipfile);
        if ($res === TRUE) {
            $shp = $shx = $dbf = false;
            $match_name = true;

            for($i=0; $i < $zip->numFiles; $i++) {
                $stat = $zip->statIndex($i);
                $fileinfo = pathinfo($stat['name']);

                if($i == 0)
                    $prev_name = $fileinfo['filename'];

                if($prev_name != $fileinfo['filename']) {
                    $match_name == false;
                    break;
                }

                switch($fileinfo['extension']) {
                    case "shp":
                        $shp = true;
                        break;
                    case "shx":
                        $shx = true;
                        break;
                    case "dbf":
                        $dbf = true;
                }
            }

            if($shp && $shx && $dbf && $match_name) {
                $zip->extractTo($extract_path);
                $zip->close();

                return array(
                    'filename'=>$fileinfo['filename'], 
                    'fullfilename'=>$extract_path . "/" . $fileinfo['filename'],
                    'fullpath'=>$extract_path
                );
            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    public function readShape($shp_file)
    {
        $shp = ms_newShapefileObj($shp_file, -1);

        if($shp->numshapes >= 1) {
            $ret = array();
            $result = $shp->getShape(0);

            $result->project($this->project[$this->srs], $this->project["900913"]);

            for ($i = 1; $i < $shp->numshapes; $i++) {
                $shape = $shp->getShape($i);

                $shape->project($this->project[$this->srs], $this->project["900913"]);
                $result = $result->union($shape);
            }

            $ret['wkt'] = $result->toWkt();

            $reg = preg_match('/^LINESTRING/', $ret['wkt']);

            // Shapes bounding box.
            $extent = $shp->bounds;
            $extent->project($this->project[$this->srs], $this->project["900913"]);

            $result = array(
                "id" => $this->id,
                "type" =>  !empty($reg) ? "LINESTRING" : "MULTILINESTRING",
                "srs" => $this->srs,
                "geometry" => $ret['wkt'],
                "bounds" => array(
                    'minx' => $extent->minx,
                    'miny' => $extent->miny,
                    'maxx' => $extent->maxx,
                    'maxy' => $extent->maxy,
                ),
                "success" => true
            );

            return $result;
        } else {
            return false;
        }
    }

    public function doUpload()
    {
        $retarr = array();
        // check file type accept zip file only
        if ($this->type == 'application/zip' || $this->type == 'application/octet-stream' || $this->type == 'application/x-zip-compressed') {

            if (move_uploaded_file($this->temp, $this->road_zip_path)) {
                if($extract = self::extractZip($this->road_zip_path, $this->temp_file)) {
                    $retarr = self::readShape($extract['fullfilename']);
                }
            }
        }

        return $retarr;
    }

    public function __destruct() 
    {
        parent::__destruct();
    }
}