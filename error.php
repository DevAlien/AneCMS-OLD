<?php
/*-------------------------------------------------------+
| AneCMS
| Copyright (C) 2010
| http://anecms.com
+--------------------------------------------------------+
| Filename: error.php
| Author: Gonçalo Margalho
+--------------------------------------------------------+
| Removal of this copyright header is strictly 
| prohibited without written permission from 
| Gonçalo Margalho.
+--------------------------------------------------------*/
define('ANECMS', true);
include './system/pages/essential.php';

$tpl->assign('typeerror', $lang['err_'.$_GET['t'].'']);
$tpl->assign('descrerror', $lang['derr_'.$_GET['t'].'']);
$tpl->burn('error1', 'tpl');
?>