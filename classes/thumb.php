<?php 
//echo $_SERVER['DOCUMENT_ROOT'];exit;
//require_once $_SERVER['DOCUMENT_ROOT'] . '/gisPteFD_V2/libs/phpthumb/ThumbLib.inc.php';
require_once dirname(__FILE__) . '/includes/init.inc.php';
require_once 'libs/phpthumb/ThumbLib.inc.php';
$id  = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
$src = isset($_REQUEST['src']) ? $_REQUEST['src'] : '';
$width  = isset($_REQUEST['width']) ? $_REQUEST['width'] : 75;
$height = isset($_REQUEST['height']) ? $_REQUEST['height'] : 75;
$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 'adaptive';
$perc = isset($_REQUEST['perc']) ? $_REQUEST['perc'] : 100;

//$path = $_SERVER['DOCUMENT_ROOT'].'/ptefd_v2_attach/PTEFD_DATA/' . $id . '/MOBILE_SNAP/' . $src;
$path = $_SERVER['DOCUMENT_ROOT'].'/'.PIC_PATH.'/'. $src;

//var_dump($path);exit;
// var_dump (file_exists ( $path ));exit;
//var_dump($path);exit;

if(file_exists ( $path )){ //echo 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';exit;
    $thumb = PhpThumbFactory::create($path);

    switch($type) {
        case 'adaptive' : 
            $thumb->adaptiveResize($width, $height)
                ->createReflection(10, 3, 10, true, '#ffffff'); 
        break;
        case 'percentage' : $thumb->resizePercent($perc); break;
        default:
            echo 'No case!!!';
    }

    $thumb->show();
} else {
    //--
}
