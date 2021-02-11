<?php //global_js_init.php
require dirname(__FILE__) . '/init.inc.php';
$remotehost = '"http://'.REMOTE_HOST.'"';
//var_dump($_SESSION['is_staff']);exit;
$jsInit = array (
    'gl_project_name' => '"' . PROJ_NAME . '"',
	'remotehost'      => $remotehost
	,'gl_permission_action'  => isset($_SESSION['session_permission_action']) ? $_SESSION['session_permission_action'] : 'null'
  
);
$pageTitle = 'celtec';
//echo $pageTitle; 
/*
foreach ($jsInit as $key => $var) {
	echo $key.$var;
}
exit;
*/
$global = '
<script>
    var ';

foreach ($jsInit as $key => $var) {
    $global .= $key . ' = ' . $var . ';';
    $global .= "\n";
    //$global .= 'console.warn({' . $key . ' : ' . $var .'});' . "\n";
}

$global .= '
document.title = "' . $pageTitle . '";

</script>';


echo $global; 