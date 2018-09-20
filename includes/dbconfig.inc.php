<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

if ($_SERVER['HTTP_HOST'] == 'xxxxx') {
    
    // Database host
    define("DB_HOST", '127.0.0.1');
    // Port
    define("PORT", '5432');
    // Database password
    define("DB_PASS", 'xxx');

	


}else if ($_SERVER['HTTP_HOST'] == 'xxxx') {
    
    // Database host
    define("DB_HOST", '127.0.0.1');
    // Port
    define("PORT", '5432');
    // Database password
    define("DB_PASS", 'xxx');


} else {

    //--> for dev
    
    // Database host
    define("DB_HOST", '127.0.0.1');
    // Port
    define("PORT", '5434');
    // Database password
    define("DB_PASS", 'pgpteadmin');


}
//--------------------------------------------------------- end if else swith server --------------------------------------------------
// Database host
define("DB_USER", 'postgres');

//--> defined db.
define("DB_CELTAC", 'celtac');
//--> defined driver.
if(true){
	define("DSN_CELTAC", 'pgsql:host= '. DB_HOST .'; dbname=' . DB_CELTAC .' port=' . PORT );
} else {
	define("DSN_CELTAC", 'mysql:host= '. DB_HOST .'; dbname=' . DB_CELTAC .' port=' . PORT );
}
//--$connection = new PDO("mysql:dbname=$db;host=$host", $username, $password);

//--> defined default for class connection.
define("DSN_DEFAULT", DSN_CELTAC);
//------------------------------------------------
// Define project name
define("PROJ_NAME", 'celtac');

// Document root
define("DOC_ROOT", $_SERVER['DOCUMENT_ROOT']);

//------------------------------------------------
//--> defined temp path.
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    // Temp file directory.
    define("TMP_FILE", 'C:/tmp');
} else {
    // Temp file directory.
    define("TMP_FILE", '/tmp');
}
