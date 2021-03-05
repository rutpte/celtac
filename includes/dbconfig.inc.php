<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

if ($_SERVER['HTTP_HOST'] == '163.44.196.239') {
    
    // Database host
    define("DB_HOST", '163.44.196.239');
    // Port
    define("PORT", '5432');
    // Database password
    define("DB_PASS", 'pgceltacadmin');//pgceltacadmin
	
}else if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1') { //localhost my room.
    
	if(true){ //--> use on real server.
		// Database host
		define("DB_HOST", '163.44.196.239');
		// Port
		define("PORT", '5432');
		// Database password
		define("DB_PASS", 'pgceltacadmin');//pgceltacadmin
		define("REMOTE_HOST", '163.44.196.239');//--> not use now.

		
	} else { //use in local for dev.
		// Database host
		define("DB_HOST", 'localhost');
		// Port
		define("PORT", '5432');
		// Database password
		define("DB_PASS", 'pgPTE@min1234');//pgceltacadmin

	}

} else {
	exit('use localhost instead.');
}

//--------------------------------------------------------- end if else swith server --------------------------------------------------
// Database host
define("DB_USER", 'postgres');

//--> defined db.
define("DB_CELTAC", 'celtac');
//--> defined db authen.
define("DB_CELTAC_AUTHEN", 'authen');
//--> defined driver.
if(true){
	define("DSN_CELTAC", 'pgsql:host= '. DB_HOST .'; dbname=' . DB_CELTAC .' port=' . PORT );
	define("DSN_CELTAC_AUTHEN", 'pgsql:host= '. DB_HOST .'; dbname=' . DB_CELTAC_AUTHEN .' port=' . PORT );
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
