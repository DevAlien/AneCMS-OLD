<?php
/*-------------------------------------------------------+
| AneCMS
| Copyright (C) 2010
| http://anecms.com
+--------------------------------------------------------+
| Filename: rss.php
| Author: Gonçalo Margalho
+--------------------------------------------------------+
| Removal of this copyright header is strictly 
| prohibited without written permission from 
| Gonçalo Margalho.
+--------------------------------------------------------*/
define('ANECMS', true);
define('RSS', true);
include './system/pages/essential.php';
include './class/rsswriter.class.php';


if(isset($_GET['module'])) {
    $module = str_replace("../", '', $_GET['module']);
    if(file_exists('./modules/'.$module.'/rss.php'))
        include './modules/'.$module.'/rss.php';
    else {
        $tpl->assign('typeerror', $lang['err_'.$_GET['t'].'']);
        $tpl->assign('descrerror', $lang['derr_'.$_GET['t'].'']);
        $tpl->burn('error1', 'tpl');
    }
}
else {
    $tpl->assign('typeerror', $lang['err_'.$_GET['t'].'']);
    $tpl->assign('descrerror', $lang['derr_'.$_GET['t'].'']);
    $tpl->burn('error1', 'tpl');
}
?>
