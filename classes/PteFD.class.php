<?php
/******************************************************************************
 * 
 * Name: Tracking.class.php
 * Purpose: Tracking classe.
 * Author:  Narong Rammanee
 *
 ******************************************************************************
 *
 * Copyright 2010 Narong <ranarong@live.com>
 *      
 * This class is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *      
 * This class is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *      
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * 
 ******************************************************************************/

require_once dirname(__FILE__) . '/DBConnection.class.php';

class PteFD extends DBConnection
{
    /**
        * __construct — Initialization connect to database. 
        * 
        * @param object $dbo a database object
        * @return No value is returned.
        */
//     public function __construct($pdo_fd2=null)
//     {
//             parent::__construct($pdo_fd2);
//     }

    public function __construct($pdo=null)
    {
            parent::__construct($pdo);
    }
    
    public function getImagesData($column, $id, $startdt, $enddt, $x='', $y='')
    {
        //--$dateCondition = ($startdt != '' && $enddt != '') ? "AND attach_date::date BETWEEN '" . self::sqlFormatDate($startdt) ."' AND '" . self::sqlFormatDate($enddt) . "'" : '';
//         $command = "
//             SELECT 
//                     mobile_attach.*
// 
//             FROM    mobile_attach 
// 
//             WHERE   1 = 1 
//                 AND (latitude is not null OR longitude is not null )
//                 AND (latitude != 'N/A' OR longitude != 'N/A')
//                 AND (latitude != '' OR longitude != '')
//                 {$xyCondition}
//                 {$dateCondition}
//         ";
//*****************************************************************
        $idColomn_Condition = ($column != '' && $id != '') ? "AND {$column} = {$id}" : '';
        $date_Condition     = ($startdt != '' && $enddt != '') ? "AND create_date::date BETWEEN '" . self::sqlFormatDate($startdt) ."' AND '" . self::sqlFormatDate($enddt) . "'" : '';
        $xy_Condition       = ($x != null && $y != null) ? " AND latitude ='{$y}' AND longitude = '{$x}'" : ''; 

        $sql = "
            SELECT 
                    *

            FROM    mobile_attach 

            WHERE   1 = 1 
                {$idColomn_Condition}
                AND (latitude is not null OR longitude is not null )
                AND (latitude != 'N/A' OR longitude != 'N/A')
                AND (latitude != '' OR longitude != '')
                {$xy_Condition}
                {$date_Condition}
                order by mobile_attach_id
        ";
        
        //--------------------------------------------------
        /*$dateCondition = ($startdt != '' && $enddt != '') ? "AND create_date::date BETWEEN ''" . self::sqlFormatDate($startdt) ."'' AND ''" . self::sqlFormatDate($enddt) . "''" : '';
        $xyCondition = ($x != null && $y != null) ? " AND latitude ='{$y}' AND longitude = '{$x}'" : ''; 
        
        $db_pro = DB_CLD_LINK;
        $sql ="
            SELECT x.* 
            FROM dblink('{$db_pro}',
                '
                    SELECT 
                            *

                    FROM    picture_attach 

                    WHERE   1 = 1 
                        AND (latitude is not null OR longitude is not null )
                        AND (latitude != ''N/A'' OR longitude != ''N/A'')
                        AND (latitude != '' OR longitude != '')
                        --AND project_id = {$projectId}
                        AND active is true
                        {$xyCondition}
                        --{$dateCondition}
                        order by attach_id
                '
                    ) AS x(attach_id TEXT, owner_id TEXT, create_date TEXT, description TEXT, latitude TEXT, longitude TEXT, filename TEXT, project_id TEXT, active TEXT) 
            WHERE 1=1
            --LIMIT 1
        ";*/
       //echo '<pre>'; echo $sql; exit;
        
        $result = $this->db->query($sql);
        //var_dump($result);exit;
        //echo $command;
        $data = array();
        if($result !== false){
                while($row = $result->fetch(PDO::FETCH_OBJ))
                        $data[] = $row;
        } else {
                echo '<pre>'; echo $sql;
                throw new PDOException('Error: getImagesData()<br />');
        }
        return $data;
    }
    
//     public function getOnlyImageData($access_key, $attach_id)
//     {
//         $command = "
//             SELECT 
//                 mobile_attach.*, 
//                 activity_base.activity_base_name,
//                 project_data.project_name 
// 
//              FROM 	mobile_attach 
//                 LEFT JOIN project_data
//                 ON mobile_attach.project_data_id = project_data.project_data_id
// 
//                 LEFT JOIN activity_base
//                 ON mobile_attach.activity_base_id = activity_base.activity_base_id
// 
//                 LEFT JOIN fdassess_projdata
//                 ON project_data.project_data_id = fdassess_projdata.project_data_id
// 
//                 LEFT JOIN fd_access_key
//                 ON fdassess_projdata.fd_accesskey_id = fd_access_key.fd_accesskey_id
// 
//             WHERE	project_data.active = true
//                 AND fd_access_key.access_key = '{$access_key}'
//                 AND mobile_attach. mobile_attach_id = '{$attach_id}'
//         ";
//         
// //         echo $command;
//         
//         $result = $this->db->query($command);
//         
//         $record = $result->fetch(PDO::FETCH_OBJ);
//         
//         return $record;
//     }
    
//     public function getProjectName($access_key)
//     {
//         $strSQL = "
//             SELECT 
//                 project_data.project_data_id,
//                 project_data.project_name 
//             FROM project_data,fd_access_key, fdassess_projdata
//             WHERE fd_access_key.fd_accesskey_id = fdassess_projdata.fd_accesskey_id
//                 AND project_data.project_data_id = fdassess_projdata.project_data_id
//                 AND project_data.active = true
//                 AND fd_access_key.access_key = '{$access_key}'
//         ";
// //         var_dump($strSQL);
//         $sth = $this->db->prepare($strSQL);
//         $sth->execute();
//         
//         $result = Array();
//         $result["items"] = $sth->fetchAll(PDO::FETCH_CLASS);
//         
//         return $result;
//     }
    
    public function reprojection($x, $y)
    {
        $coordinates = ms_newPointObj();
        $coordinates->setXY($y, $x);
        $E4326   = "proj=latlong";
        $E900913 = "proj=merc,a=6378137,b=6378137,lat_ts=0.0,lon_0=0.0," .
            "x_0=0.0,y_0=0,k=1.0,units=m,nadgrids=@null,no_defs";
            
        $proj4326  = ms_newprojectionobj($E4326);
        $proj900913 = ms_newprojectionobj($E900913);
        
        $coordinates->project($proj4326, $proj900913);
        
        return $coordinates;
    }
    
    
    public function sqlFormatDate($date)
    {
        $dateArr = explode('/', $date);
        
        return $dateArr[2] . '-' . $dateArr[1] . '-' . $dateArr[0];
    }
    
    public function getBoundFromMultiPoint()
    {
        
    }
    //********************************************************************************************
    public function saveDB($post, $file_pic)
    {
//          var_dump($post);
//          var_dump($file_pic);
//          exit;

//         var_dump($post["lonlat"]);
//         exit;
        
        /*
        array(5) {
        ["description"]=>
        string(4) "test"
        ["q"]=>
        string(14) "upload_picture"
        ["project_id"]=>
        string(2) "19"
        ["owner_id"]=>
        string(2) "15"
        ["lonlat"]=>
        string(37) "100.47599714514546,13.683485800427707"
        }
        string(76) "09-28-2015 07:55:32.732600_1620817_840503192635811_3207809130480104152_n.jpg"
        */
    
//     var_dump($lonlat);exit;

    //-------------------------------------
    $lonlat = explode(",", $post["lonlat"]);
    
    $date   = new DateTime();
    $dt     = $date->format('Y-m-d H:i:s');//yyyy-mm-dd hh:mm:ss
    //-------------------------------------
    $owner_id       = isset($_POST["owner_id"]) ? trim($_POST["owner_id"]) : "";
    $description    = isset($_POST["description"]) ? trim($_POST["description"]) : "";
    $filename       = isset($file_pic) ? trim($file_pic) : "";
    $project_id     = isset($_POST["project_id"]) ? trim($_POST["project_id"]) : "";
    $longitude      = isset($lonlat[0]) ? trim($lonlat[0]) : "";
    $latitude       = isset($lonlat[1]) ? trim($lonlat[1]) : "";
    $create_date    = $dt;
    //-------------------------------------
    self::doLog('upload_picture by owner_id = '.$owner_id .' ,filename->'.$project_id);
    //-------------------------------------
        $sql = "
            INSERT INTO picture_attach (
                
                owner_id
                , create_date
                , description
                , filename
                , project_id
                , longitude
                , latitude
                , active

            )
            VALUES
        ";
//         $sql_edit = "
//             INSERT INTO picture_attach (
//                 update_by
//                 , update_date
//                 , description
//                 , filename
//                 , project_id
//                 , longitude
//                 , latitude
// 
//             )
//             VALUES
//         ";
//--------------------------------
//                 , sta character
//                 , road_code
//                 , province_id
//                 , amphur_id
//                 , tambon_id
        $sql .= "
            (
                '{$owner_id}'
                , '{$create_date}'
                , '{$description}'
                , '{$filename}'
                , {$project_id}
                , '{$longitude}'
                , '{$latitude}'
                , 't'
            )
        ";
        
        //echo '<pre>'; echo $sql; exit;
        
                $sth = $this->db->prepare($sql);
                if (!$sth->execute()) {
                    echo $sql;
                    print_r($sth->errorInfo());
                    //-----------------------------
                    $result = array(
                        "success"       => false
                    );
                    return  $result;
                    exit;
                    //-----------------------------
                } else {
                    $result = array(
                        "success"       => true
                    );
                    return  $result;
                }
    }
    
    //------------------------------------------------------
    public function extractZip($zipfile, $extract_path)
    {
     var_dump($zipfile);exit;
//     var_dump($extract_path);
     //exit;
        //how to zip is : no zip with folder but zip on files in folder_root contain
        $zip = new ZipArchive;
        $res = $zip->open($zipfile);
        var_dump($res);exit;
        if ($res === TRUE) {
            $ex_file = false;
            $sum_file_name = array();

            for($i=0; $i < $zip->numFiles; $i++) {
                $stat = $zip->statIndex($i);
                
                $fileinfo = pathinfo($stat['name']);
                
                //--> push for debug (print_r)
                array_push($sum_file_name, $fileinfo['filename']);

                //var_dump($fileinfo);
                switch($fileinfo['extension']) {
                    case "jpg":
                        $ex_file = true;
                        break;
                    case "png":
                        $ex_file = true;
                        break;
                    case "gif":
                        $ex_file = true;
                }
            }
            if($ex_file) {
                $zip->extractTo($extract_path);
                $zip->close();

                return array(
                    'filename'      => $fileinfo['filename'], 
                    'fullfilename'  => $extract_path . "/" . $fileinfo['filename'],  // --> $extract_path is tmp/
                    'fullpath'      => $extract_path
                );
            } else {
                echo $ex_file . 'no have complete any file ';
                //print_r($sum_file_name);
                return false;
            }



        } else {
            echo 'zip can not open';
            return false;
        }
    }
    //public function picUpload($file=null, $post=null, $temp_file=null, $pic_zip_path=null, $backup_path=null)
    public function picUpload($file=null, $post=null, $temp_file=null, $backup_path=null)
    {
//         var_dump(count($file['uploadfile']['name']));exit;
//         $count_pic = count($file['uploadfile']['name']);
//         for ($i = 0; $i <= $count_pic-1; $i++) {
//             //var_dump($file['uploadfile']['name'][$i]);
//         }
//         exit;
        $count_pic = count($file['uploadfile']['name']);
        for ($i = 0; $i <= $count_pic-1; $i++) {
            //$project_id               = isset($post['project_id']) ? $post['project_id'] : "";
            //$owner_id                 = isset($post['owner_id']) ? $post['owner_id'] : "";
            $type                     = isset($file['uploadfile']['type'][$i]) ? $file['uploadfile']['type'][$i] : "";
            $temp_pic_upload          = isset($file['uploadfile']['tmp_name'][$i]) ? $file['uploadfile']['tmp_name'][$i] : "";
            $name                     = isset($file['uploadfile']['name'][$i]) ? $file['uploadfile']['name'][$i] : "";
            
            $temp_file                = isset($temp_file) ? $temp_file : ""; //TMP_FILE not use in this fn
            //$pic_zip_path             = isset($pic_zip_path) ? $pic_zip_path : "";
            $retarr = array();
            $rs = array();
            //if ($type == 'application/zip' || $type == 'application/octet-stream' || $type == 'application/x-zip-compressed') {
            if ($type == 'image/jpeg' || $type == 'image/png' || $type == 'image/gif') {
                
                $now = DateTime::createFromFormat('U.u', microtime(true));
                //$now = DateTime::createFromFormat('H:i:s', microtime(true));
                $micro_date = microtime();
                $date_array = explode(" ",$micro_date);
                $date = date("Y-m-d H:i:s");
                //--$new_name = $now->format("m-d-Y H:i:s.u").'_'.$name;//exit;
                $new_name = $date.$now->format("s.u").'_'.$name;//exit;
                //var_dump(DOC_ROOT.$backup_path.'/'.$new_name);exit;
                if (move_uploaded_file($temp_pic_upload, DOC_ROOT.'/'.$backup_path.'/'.$new_name)) {
                    /*
                    if($extract = self::extractZip($pic_zip_path, $backup_path)) {
                        $retarr = self::saveDB($post, $extract['fullfilename']);// insert to db afer call this fn "saveGeometry"
                    } else {
                        echo "file zip can't not extract";
                    } */
                    //var_dump('ok');exit;
                    $retarr = self::saveDB($post, $new_name);
                    if( $retarr["success"] === false){
                        echo 'can not save to db';
                        array_push($rs,"false");
                    } else {
                        array_push($rs,"true");
                    }
                } else {
                    echo 'can not move_uploaded_file';
                    array_push($rs,"false");
                }
            } else {
                //$retarr["msg"] = 'save only project';
                echo 'wrong type picture upload';
                array_push($rs,"false");
            }
        }//--> end loop pic
        //------------------
        if (in_array("false", $rs)) {
            $result = array(
                "success" => false
            );
            return  $result;
        } else {
            $result = array(
                "success" => true
            );
            return  $result;
        }
                //--var_dump($rs);exit;
        //--return $rs;
    }
    //---------------------------------------------------------------------------
    
     public function update_picture_comment($picture_id, $update_text){
        self::doLog('update_picture pic_id = '.$picture_id);
        //*************************************
        $sql = "
            UPDATE picture_attach SET description = '{$update_text}'
            WHERE attach_id = '{$picture_id}';
        ";
        //echo $sql;
        //$this->db->query($sql);
        // -----------------------------------
        $sth = $this->db->prepare($sql);
        
        try {
            $sth->execute();
            $result = array(
                "success"                   => true
            );
            return  $result;
        } catch (Exception $e) {
            echo "ERROR : ".$sql;
            print_r($sth->errorInfo());
            exit;
        }
     }
    //---------------------------------------------------------------------------
    
     public function delete_picture($picture_id){
        self::doLog('delete_picture pic_id = '.$picture_id);
        //*************************************
        $sql = "
            UPDATE picture_attach SET active = 'f'
            WHERE attach_id = '{$picture_id}';
        ";
        //echo $sql;
        //$this->db->query($sql);
        // -----------------------------------
        $sth = $this->db->prepare($sql);
        
        try {
            $sth->execute();
            $result = array(
                "success"                   => true
            );
            return  $result;
        } catch (Exception $e) {
            echo "ERROR : ".$sql;
            print_r($sth->errorInfo());
            exit;
        }
     }
     
     //--------------------------------------------------------------------------
    public function doLog($event)
    {
    //self::doLog('xxx');
    // open log file
    $filename = "log_picture.log";
    $fh = fopen($filename, "a") or die("Could not open log file.");
    fwrite($fh, date("d-m-Y, H:i")." - ip :".$_SERVER["REMOTE_ADDR"]." -event : $event"." - computer_name : ".gethostname()." - browser : ".$_SERVER["HTTP_USER_AGENT"]."\n") or die("Could not write file!");
    fclose($fh);
    }
    /**
     * __destruct — Database close connection
     * 
     * @return No value is returned.
     */
    public function __destruct() 
    {
        parent::__destruct();    
    }
}
