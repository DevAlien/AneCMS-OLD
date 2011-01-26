<?php
define('ANECMS', true);
define('XMLRPC', true);
include './system/pages/essential.php';
include './class/iXR_library.inc.php';


if(isset($_GET['module'])) {
    $module = str_replace("../", '', $_GET['module']);
    if(file_exists('./modules/'.$module.'/xmlrpc.php'))
        include './modules/'.$module.'/xmlrpc.php';
    else {
        echo 'There is not an xmlrpc file in the '.$_GET['module'].'';
        die();
    }
}
else {
    echo 'No module selected';
    die();
}
?>
