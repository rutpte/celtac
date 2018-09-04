<?php
require_once dirname(__FILE__) . '/dbconfig.inc.php';
/*
// Define project name
define("PROJ_NAME", '/gisCldIntegration');

// Document root
define("DOC_ROOT", $_SERVER['DOCUMENT_ROOT']);

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    // Temp file directory.
    define("TMP_FILE", 'C:/tmp');
} else {
    // Temp file directory.
    define("TMP_FILE", '/tmp');
}

define("PIC_PATH", 'gisCldIntegration_picture');

define("DSN_CLD", 'pgsql:host= '. DB_HOST .'; dbname=' . DB_CLD);
define("DSN_PROTOPJ", 'pgsql:host= '. DB_HOST .'; dbname=' . DB_PROTOPJ);

define('DB_CLD_LINK','dbname=' . DB_CLD . ' user=' . DB_USER . ' password=' . DB_PASS);
define('DB_PROTOPJ_LINK','dbname=' . DB_PROTOPJ . ' user=' . DB_USER . ' password=' . DB_PASS);
*/

if (isset($_SESSION['phase_edit'])) {

} else if (isset($_GET['phase_edit'])) {
    $_SESSION['phase_edit'] = $_GET['phase_edit'];
} else {
    $_SESSION['phase_edit'] = null;
}

if (isset($_SESSION['all'])) {

} else if (isset($_GET['all'])) {
    $_SESSION['all'] = $_GET['all'];
} else {
    $_SESSION['all'] = false;
}

if (isset($_SESSION['phase'])) {

} else if (isset($_GET['phase'])) {
    $_SESSION['phase'] = $_GET['phase'];
} else {
    $_SESSION['phase'] = null;
}

// if ($_SESSION['all']) {
    $_SESSION['gl_workspace'] = '"IntegrationAll"';
// } else {
//     echo "no use"; exit;
//     if ($_SESSION['phase'] == 1) {
//         $_SESSION['gl_workspace'] = '"Integration"';
//     } else {
//         $_SESSION['gl_workspace'] = '"IntegrationII"';
//     }
// }

// echo '<pre>>>>';
// echo "ALL: ", ($_SESSION['all'] ? 'true' : 'false'), "<br />";
// echo "PHASE: ", ($_SESSION['phase']) ? $_SESSION['phase'] : 'null', "<br />";
// echo "PHASE EDIT: ", ($_SESSION['phase_edit']) ? 'true' : 'false', "<br />";
// echo "SESSION ALL: "; var_dump($_SESSION['all']);
// echo '</pre>';

$integration = new Integration();

//if ($_SESSION['all']) {
    // Initial session provinces.
$integration->initSessionProvinces();


$dsn = 'pgsql:host= '. DB_HOST .'; dbname=' . DB_LMP;
//} else {
//     if ($_SESSION['phase'] == 1) {
//         $dsn = 'pgsql:host= '. DB_HOST .'; dbname=' . DB_INTEGRATION;
//     } else {
//         $dsn = 'pgsql:host= '. DB_HOST .'; dbname=' . DB_INTEGRATIONII;
//     }
//}

// Initial workspace
$integration->initWorkspace();
// var_dump($_SESSION['phase_edit']);
try {
    $pdoIntegration = new PDO(DSN_LMP, DB_USER, DB_PASS);
    $pdoProtoPj = new PDO(DSN_PROTOPJ, DB_USER, DB_PASS);
    $pdoCld = new PDO(DSN_CLD, DB_USER, DB_PASS);
	$pdoGisLmp = new PDO(DSN_LMP, DB_USER, DB_PASS); //--> pdoGisLmp it is the same value as $pdoIntegration.

    //------------------------------------------------------
    $pdoIntegration->setAttribute(PDO::ATTR_EMULATE_PREPARES,  false);
    $pdoIntegration->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdoProtoPj->setAttribute(PDO::ATTR_EMULATE_PREPARES,  false);
    $pdoProtoPj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $pdoCld->setAttribute(PDO::ATTR_EMULATE_PREPARES,  false);
    $pdoCld->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$pdoGisLmp->setAttribute(PDO::ATTR_EMULATE_PREPARES,  false);
    $pdoGisLmp->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'Connection failed: <pre>' .  $e->getMessage();
}

// Automatically called in case you are trying to use a class.
function __autoload($classname) 
{
    $filename = DOC_ROOT . PROJ_NAME . '/classes/' . $classname . '.class.php';
    if(file_exists($filename)) {
        require_once $filename;
    } else {
        throw new Exception('Unable to load ' . $filename);
    }
}

function recursive_array_search($needle, $haystack)
{
    foreach($haystack as $key=>$value) {
        $current_key=$key;
        if($needle===$value OR (is_array($value) && recursive_array_search($needle,$value) !== false)) {
            return $current_key;
        }
    }

    return false;
}