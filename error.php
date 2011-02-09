<?php
define('ANECMS', true);
include './system/pages/essential.php';

$tpl->assign('typeerror', $lang['err_'.$_GET['t'].'']);
$tpl->assign('descrerror', $lang['derr_'.$_GET['t'].'']);
$tpl->burn('error1', 'tpl');
?>