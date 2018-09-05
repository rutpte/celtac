<?php
    require_once dirname(__FILE__) . '/includes/init.inc.php';
    $id_reset = isset($_GET['id_reset']) ? $_GET['id_reset'] : '';
    $secure_code = isset($_GET['secure_code']) ? $_GET['secure_code'] : '';

    $mu = new UserManage($pdo);
    $rs = $mu->confirmResetPassword($id_reset, $secure_code);
    //var_dump($rs);
    $massage = "";
?>

<!DOCTYPE html>
<html>
<head>
    <script src="libs/jquery/jquery-1.10.2.min.js"></script> 
     <script>
     $(function(){
        <?php if($rs["success"]){ ?>
            $("#includedContent").load("show_status_success_reset_password.html"); 
        <?php } else { ?>
            $("#includedContent").load("show_status_fail_reset_password.html"); 
        <?php } ?>
    });
        </script> 
</head>
<body>


    <div id="includedContent"></div>
</body>
</html>