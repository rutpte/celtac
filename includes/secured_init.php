<?php
require dirname(__FILE__) . '/init.inc.php';

$variable_init = array (
    'arcgis_user'          => ARCGIS_USER,
    'arcgis_pass'    => ARCGIS_PASS
);
echo json_encode($variable_init);
