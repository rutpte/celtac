<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
//var_dump($_SERVER['HTTP_HOST']);exit;
//echo $_SERVER['HTTP_REFERER'];
//echo $_SERVER['REMOTE_ADDR'];

if ($_SERVER['HTTP_HOST'] == 'xxxxx') {//192.168.157.37,lmp.drr.go.th
    // Database host
    define("DB_HOST", '127.0.0.1');

    // Database password
    define("DB_PASS", 'xxxxxx');
    
    //--> wms layer
    define("HOST_WMS", 'xxxx');
	
	# [dblink]
	define('DBLINK_HOST', '127.0.0.1');
	define('DBLINK_DB', 'xxxx');
	define('DBLINK_PORT', '5432');
	define('DBLINK_USER', 'postgres');
	define('DBLINK_PASS', 'xxxx');
	define('HOST_VIDEO', 'xxxx');

}else if ($_SERVER['HTTP_HOST'] == 'xxxx') {
    //Database host

    define("DB_HOST", 'xxxx');
    //define("DB_HOST", 'mapdb.pte.co.th');
    
    // Database password
    define("DB_PASS", 'xxxx');
    
    //--> wms layer and use for app host
    define("HOST_WMS", 'xxxxxx');
	
	# [dblink]
	define('DBLINK_HOST', '172.23.0.34');
	define('DBLINK_DB', 'xxxx');
	define('DBLINK_PORT', '5432');
	define('DBLINK_USER', 'postgres');
	define('DBLINK_PASS', 'xxxx');
	define('HOST_VIDEO', 'xxxx');

} else {

    //--> for dev
    
    // Database host
    define("DB_HOST", 'xxxxx');//mapdb
    //--define("DB_HOST", 'mapdb.pte.co.th');
    
    // Database password
    define("DB_PASS", 'xxxxx');
    
    //--> wms layer
    define("HOST_WMS", 'xxxxx');
	
	# [dblink mapdb]


}
//--------------------------------------------------------- end if else swith server --------------------------------------------------
// Database host
define("DB_USER", 'postgres');
define("DB_PROTOPJ", 'protopj');
define("DB_CLD", 'drr_cld_db');
// define("DB_INTEGRATION", 'gis_integration');
// define("DB_INTEGRATIONII", 'gis_integrationii');
define("DB_LMP", 'gis_lmp');
//------------------------------------------------
//--define("HOST_WMS", $_SERVER['HTTP_HOST']);
//define("HOST_WMS", '192.168.9.19');

//------------------------------------------------
// Define project name
define("PROJ_NAME", '/gisLmp');

// Document root
define("DOC_ROOT", $_SERVER['DOCUMENT_ROOT']);

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    // Temp file directory.
    define("TMP_FILE", 'C:/tmp');
} else {
    // Temp file directory.
    define("TMP_FILE", '/tmp');
}
//------------------------------------------------

//------------------------------------------------


define("DSN_LMP", 'pgsql:host= '. DB_HOST .'; dbname=' . DB_LMP);

