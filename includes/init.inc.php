<?php
require_once dirname(__FILE__) . '/dbconfig.inc.php';
$_SESSION['logined']  = false;
try {
    $pdoCeltac = new PDO(DSN_CELTAC, DB_USER, DB_PASS);


    //------------------------------------------------------
    $pdoCeltac->setAttribute(PDO::ATTR_EMULATE_PREPARES,  false);
    $pdoCeltac->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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