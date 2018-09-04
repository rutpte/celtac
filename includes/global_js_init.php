<?php
require dirname(__FILE__) . '/init.inc.php';
$remotehost = 'http://'.HOST_WMS;//http://mapdb.pte.co.th //--> for wms layer it have to use ip or name of server of tocat
$obj_gobal = new Golbal_init($pdoGisLmp);

//--> check exit table. --------------------------------------------------------------------------
$check_exit_table_transfer 					= $obj_gobal->getLmpTransferTableName("transfer");
$check_exit_table_transfer_track 			= $obj_gobal->getLmpTransferTableName("transfer_track");

$check_exit_table_transfer_incomplete 		= $obj_gobal->getLmpTransferTableName("transfer_incomplete");
$check_exit_table_transfer_incomplete_track = $obj_gobal->getLmpTransferTableName("transfer_incomplete_track");

$check_exit_table_transfer_other 			= $obj_gobal->getLmpTransferTableName("transfer_other");
$check_exit_table_transfer_other_track 		= $obj_gobal->getLmpTransferTableName("transfer_other_track");
//-------------------------------------------------------------------------------------------------
// echo "<pre>";
// var_dump($check_exit_table_transfer);
// echo "test"; exit;
$rs_province_all_short_name = $obj_gobal->get_province_all('short_name'); //key_first ='short_name'
$rs_province_all_province_id = $obj_gobal->get_province_all('province_id'); 


// echo '<pre>';
// print_r($rs_lmp_transfer_table_name); exit;
$jsInit = array (
    'gl_all'          => $_SESSION['all'] == true ? 'true' : 'false',
    'gl_workspace'    => $_SESSION['gl_workspace'],
    'gl_project_name' => '"' . PROJ_NAME . '"',
    'gl_bypass'       => isset($_SESSION['bypass']) ?  $_SESSION['bypass'] : 'false',
    //'gl_editable'     => isset($_SESSION['editable']) ?  $_SESSION['editable'] : 'false',
    'gl_way_id'       => isset($_SESSION['way_id']) ?  $_SESSION['way_id'] : 'false',
    //'gl_misLength'    => isset($_SESSION['dist']) ?  $_SESSION['dist'] : 0,
    'gl_layers_group' => isset($_SESSION['layers_group']) ? '"' . $_SESSION['layers_group'] . '"' : '"ADMINISTRATIVE_DISTRIC,BASELAYER,ROAD_NETWORK,LOCAL_ROAD"',
    'gl_username'     => isset($_SESSION['username']) ? '"' . $_SESSION['username'] . '"' : '"admin"',
    'gl_phase'        => isset($_SESSION['phase']) ? $_SESSION['phase'] : 'false',
    'gl_phase_edit'   => isset($_SESSION['phase_edit']) ? 'true' : 'false',
    'gl_remote_host'  => '"' . $remotehost . '"',
    'gl_provinces'    => json_encode($_SESSION['provinces']),
    'gl_provinces_short_name'    => json_encode($rs_province_all_short_name),
	'gl_provinces_province_id'    => json_encode($rs_province_all_province_id),
    'gl_hidden_integration' => 'false',
    'gl_dsn'          => '"' . $dsn . '"'
	
    ,'gl_check_exit_table_transfer' 					=> isset($check_exit_table_transfer) ? $check_exit_table_transfer : 'false'
	,'gl_check_exit_table_transfer_track' 				=> isset($check_exit_table_transfer_track) ? $check_exit_table_transfer_track : 'false'
	
	,'gl_check_exit_table_transfer_incomplete' 			=> isset($check_exit_table_transfer_incomplete) ? $check_exit_table_transfer_incomplete : 'false'
	,'gl_check_exit_table_transfer_incomplete_track' 	=> isset($check_exit_table_transfer_incomplete_track) ? $check_exit_table_transfer_incomplete_track : 'false'
	
	,'gl_check_exit_table_transfer_other' 				=> isset($check_exit_table_transfer_other) ? $check_exit_table_transfer_other : 'false'
	,'gl_check_exit_table_transfer_other_track' 		=> isset($check_exit_table_transfer_other_track) ? $check_exit_table_transfer_other_track : 'false'
);
$pageTitle = 'local road basemap';
// if (isset($_SESSION['all'])) {
//     $pageTitle = 'บูรณาการ Server CLD';
// } else if (isset($_SESSION['phase']) && $_SESSION['phase'] == 1) {
//     if (isset($_SESSION['phase_edit']) && $_SESSION['phase_edit'] == 'true') {
//         $pageTitle = 'บูรณาการ เฟส 1 (ปรับปรุง)';
//     } else {
//         $pageTitle = 'บูรณาการ เฟส 1';
//     }
// } else if (isset($_SESSION['phase'])  && $_SESSION['phase'] == 2) {
//     if (isset($_SESSION['phase_edit']) && $_SESSION['phase_edit'] == 'true') {
//         $pageTitle = 'บูรณาการ เฟส 2 (ปรับปรุง)';
//     } else {
//         $pageTitle = 'บูรณาการ เฟส 2';
//     }
// }

$global = '
<script>
    var ';

foreach ($jsInit as $key => $var) {
    $global .= $key . ' = ' . $var . ';';
    $global .= "\n";
    $global .= 'console.warn({' . $key . ' : ' . $var .'});' . "\n";
}

$global .= '
document.title = "' . $pageTitle . '";
function toggleMiniMap()
{
    if (jQuery(".minimap").css("right") === "2px") {
        hideMiniMap ();
        jQuery("#toggleImg").attr("title", "แสดงแผนที่");
    } else {
        showMiniMap();
        jQuery("#toggleImg").attr("title", "ซ่อนแผนที่");
    }
}

function hideMiniMap()
{
    jQuery(".minimap" ).animate({
        right: -1000
    }, {
        duration: 500
    });

}

function showMiniMap ()
{
    jQuery(".minimap" ).animate({
        right: 2
    }, {
        duration: 500
    });
}
</script>';


echo $global;

// Unset session for leave map edit.
unset($_SESSION['editable']);